<?php
/**
 * Created by PhpStorm.
 * User: tannergriffin
 * Date: 12/1/2016
 * Time: 8:31 PM
 */

namespace Finance\Controllers;


use Entry;
use Finance\Http\StatusCodes;
use PDO;
use Finance\Utilities\DatabaseConnection;

class EntryController
{

    public function postEntry($args)
    {
        $data = (object)json_decode(file_get_contents('php://input'));
        $dbo = DatabaseConnection::getInstance();

        $entryName = strip_tags($data->entryName);
        $entryValue = strip_tags($data->entryValue);
        $categoryId = strip_tags($data->categoryId);

        $query_create_entry = '
        INSERT INTO Entry
        (EntryName)
        VALUES 
        (:entryName, :entryValue, :categoryId)
        ';

        $statement_create_entry = $dbo->prepare($query_create_entry);
        $statement_create_entry->bindParam(':entryName', $entryName);
        $statement_create_entry->bindParam(':entryValue', $entryValue);
        $statement_create_entry->bindParam(':categoryId', $categoryId);

        if (!$statement_create_entry->execute()) {
            http_response_code(StatusCodes::BAD_REQUEST);
            return array(
                "error" => "Entry not created in database."
            );
        }

        $entryId = $dbo->lastInsertId();
        $entry = new Entry($entryId, $entryName, $entryValue, $categoryId);

        return $entry->jsonSerialize();
    }

    public function putEntry($args)
    {
        $data = (object)json_decode(file_get_contents('php://input'));
        $dbo = DatabaseConnection::getInstance();

        $entryName = strip_tags($data->entryName);
        $entryId = strip_tags($data->entryId);
        $entryValue = strip_tags($data->entryValue);
        $categoryId = strip_tags($data->categoryId);

        $query_update_entry = '
        UPDATE Entry
        SET EntryName = :entryName
        WHERE EntryId = :entryId
        ';

        $statement_update_entry = $dbo->prepare($query_update_entry);
        $statement_update_entry->bindParam(':entryName', $entryName);
        $statement_update_entry->bindParam(':entryId', $entryId);
        $statement_update_entry->bindParam(':entryValue', $entryValue);
        $statement_update_entry->bindParam(':categoryId', $categoryId);

        if (!$statement_update_entry->execute()) {
            http_response_code(StatusCodes::BAD_REQUEST);
            return array(
                "error" => "Entry not updated in database."
            );
        }

        $entry = new Entry($entryId, $entryName, $entryValue, $categoryId);

        return $entry->jsonSerialize();
    }

    public function deleteEntry($args)
    {
        $data = (object)json_decode(file_get_contents('php://input'));
        $dbo = DatabaseConnection::getInstance();

        $entryId = strip_tags($data->entryId);

        $query_delete_entry = '
        DELETE FROM Entry
        WHERE EntryId = :entryId
        ';

        $statement_delete_entry = $dbo->prepare($query_delete_entry);
        $statement_delete_entry->bindParam(':entryId', $entryId);

        if (!$statement_delete_entry->execute()) {
            http_response_code(StatusCodes::BAD_REQUEST);
            return array(
                "error" => "Entry not deleted in database."
            );
        }

        return array(
            "deleted" => $statement_delete_entry->rowCount()
        );
    }

    public function getEntry($args)
    {

        // Get League ID
        $entryId = $args['id'];
        $dbo = DatabaseConnection::getInstance();


        $query_select_entry = '
        SELECT EntryId, EntryName, EntryValue, CategoryId
        FROM Entry
        WHERE EntryId = :entryId
        ';

        $statement_select_entry = $dbo->prepare($query_select_entry);
        $statement_select_entry->bindParam(':entryId', $entryId);

        if (!$statement_select_entry->execute()) {
            http_response_code(StatusCodes::BAD_REQUEST);
            return array(
                "error" => "Query failed."
            );
        }

        $result = $statement_select_entry->fetchAll(PDO::FETCH_ASSOC);

        $entry = new Entry(
            $result['EntryId'],
            $result['EntryName'],
            $result['EntryValue'],
            $result['CategoryId']
        );


        return $entry->jsonSerialize();
    }

    public function getCategories($args)
    {

        $dbo = DatabaseConnection::getInstance();


        $query_select_entry = '
        SELECT EntryId, EntryName, EntryValue, CategoryId
        FROM Entry
        ';

        $statement_select_entry = $dbo->prepare($query_select_entry);

        if (!$statement_select_entry->execute()) {
            http_response_code(StatusCodes::BAD_REQUEST);
            return array(
                "error" => "Query failed."
            );
        }

        $result = $statement_select_entry->fetchAll(PDO::FETCH_ASSOC);

        $categories = [];
        foreach ($result as $entry) {
            array_push($categories, array(
                'EntryId'=>$entry['EntryId'],
                'EntryName'=>$entry['EntryName'],
                'EntryValue'=>$entry['EntryValue'],
                'CategoryId'=>$entry['CategoryId']
            ));
        }

        return $categories;
    }
}
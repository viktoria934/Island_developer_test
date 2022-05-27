<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function get_island_users()
{

    global $wpdb, $table_prefix;
    $result = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $table_prefix . "island_users"));

    return $object = array(
        'code' => 200,
        'result' => $result
    );
}

function add_island_user(WP_REST_Request $request)
{

    $island_user_name = (string)$request['name'];

    global $wpdb, $table_prefix;
    $result = $wpdb->insert($table_prefix . "island_users", array(
        'name' => addslashes($island_user_name),
    ));

    $last_id = $wpdb->insert_id;

    $result = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $table_prefix . "island_users WHERE id = " . $last_id . " ORDER BY id "));

    generateItems($last_id);

    return $object = array(
        'code' => 200,
        'result' => $result
    );
}

function delete_island_user(WP_REST_Request $request)
{

    $island_user_id = (int)$request['id'];

    global $wpdb, $table_prefix;
    $result = $wpdb->delete($table_prefix . "island_users", array(
        'id' => $island_user_id,
    ));

    return $object = array(
        'code' => 200,
        'result' => "DELETED"
    );
}

function edit_island_user(WP_REST_Request $request)
{

    $island_user_id = (int)$request['id'];
    $island_user_name = (string)$request['name'];

    global $wpdb, $table_prefix;
    $result = $wpdb->update($table_prefix . "island_users", array(
        'name' => $island_user_name
    ), array(
        'id' => $island_user_id
    ));

    $result = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $table_prefix . "island_users WHERE id = " . $island_user_id . " ORDER BY id "));

    return $object = array(
        'code' => 200,
        'result' => $result
    );
}

function get_island_user(WP_REST_Request $request)
{
    $id_user = (int)$request['id'];
    global $wpdb, $table_prefix;
    $result = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $table_prefix . "island_users
        WHERE id = " . $id_user));

    $items = $wpdb->get_results($wpdb->prepare("SELECT " . $table_prefix . "island_items.name, " . $table_prefix . "island_items.value FROM 
   `" . $table_prefix . "island_users` INNER JOIN " . $table_prefix . "island_user_items ON " . $table_prefix . "island_user_items.id_user = 
   " . $table_prefix . "island_users.id INNER JOIN " . $table_prefix . "island_items ON " . $table_prefix . "island_items.id = 
   " . $table_prefix . "island_user_items.id_item WHERE " . $table_prefix . "island_users.id = " . $id_user));

    return $object = array(
        'code' => 200,
        'result' => $result,
        'items' => $items
    );
}

function get_island_items()
{

    global $wpdb, $table_prefix;
    $result = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $table_prefix . "island_items"));

    return $object = array(
        'code' => 200,
        'result' => $result
    );
}

function add_island_item(WP_REST_Request $request)
{

    $island_item_name = (string)$request['name'];
    $island_item_value = (int)$request['value'];

    global $wpdb, $table_prefix;
    $result = $wpdb->insert($table_prefix . "island_items", array(
        'name' => addslashes($island_item_name),
        'value' => $island_item_value,
    ));

    $last_id = $wpdb->insert_id;

    $result = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $table_prefix . "island_items WHERE id = " . $last_id . " ORDER BY id "));

    return $object = array(
        'code' => 200,
        'result' => $result
    );
}

function get_island_item(WP_REST_Request $request)
{
    $id_item = (int)$request['id'];
    global $wpdb, $table_prefix;
    $result = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $table_prefix . "island_items
        WHERE id = " . $id_item));

    return $object = array(
        'code' => 200,
        'result' => $result
    );
}

function delete_island_item(WP_REST_Request $request)
{

    $island_item_id = (int)$request['id'];

    global $wpdb, $table_prefix;
    $result = $wpdb->delete($table_prefix . "island_items", array(
        'id' => $island_item_id,
    ));

    return $object = array(
        'code' => 200,
        'result' => "DELETED"
    );
}

function add_island_lot(WP_REST_Request $request)
{
    global $wpdb, $table_prefix;
    $island_creator_id = (int)$request['creator_id'];
    $island_consumer_id = (int)$request['consumer_id'];
    $island_creator_items = (string)$request['creator_items'];
    $island_consumer_items = (string)$request['consumer_items'];

    if ($island_creator_id === $island_consumer_id || $island_creator_id === 0) {
        return $object = array(
            'code' => 200,
            'result' => "Check consumer_id and creator_id"
        );
    }

    if (!checkUser($island_creator_id)) {
        return $object = array(
            'code' => 200,
            'result' => "User " . $island_creator_id . " doesn't exist"
        );
    }
    if ($island_consumer_id != 0) {
        if (!checkUser($island_consumer_id)) {
            return $object = array(
                'code' => 200,
                'result' => "User " . $island_creator_id . " doesn't exist"
            );
        }
    }

    $island_creator_items = json_decode($island_creator_items);
    $island_consumer_items = json_decode($island_consumer_items);

    if (!checkUserItems($island_creator_id, $island_creator_items)) {
        return $object = array(
            'code' => 200,
            'result' => "Check creator items, please"
        );
    }

    if ($island_consumer_id != 0) {
        if (!checkUserItems($island_creator_id, $island_consumer_items)) {
            return $object = array(
                'code' => 200,
                'result' => "Check consumer items, please"
            );
        }
    } else {
        if (!checkTotal($island_consumer_items)) {
            return $object = array(
                'code' => 200,
                'result' => "Check consumer items, please"
            );
        }
    }

    if ($island_creator_items->total < $island_consumer_items->total) {
        return $object = array(
            'code' => 200,
            'result' => "your total amount is less than needed"
        );
    }

    $result = $wpdb->insert($table_prefix . "island_lots", array(
        'creator_id' => $island_creator_id,
        'consumer_id' => $island_consumer_id,
        'status' => 'open',
        'creator_items' => json_encode($island_creator_items),
        'consumer_items' => json_encode($island_consumer_items),
    ));

    $last_id = $wpdb->insert_id;

    $result = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $table_prefix . "island_lots WHERE id = " . $last_id . " ORDER BY id "));

    return $object = array(
        'code' => 200,
        'result' => $result
    );
}

function get_island_available_lots()
{
    global $wpdb, $table_prefix;
    $result = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $table_prefix . "island_lots
        WHERE consumer_id = 0"));


    return $object = array(
        'code' => 200,
        'result' => $result
    );
}

function get_island_own_lots(WP_REST_Request $request)
{
    $id_item = (int)$request['id'];
    global $wpdb, $table_prefix;

    $result = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $table_prefix . "island_lots
        WHERE creator_id =" . $id_item));

    return $object = array(
        'code' => 200,
        'result' => $result
    );
}

function get_island_consumer_lots(WP_REST_Request $request)
{
    $id_item = (int)$request['id'];
    global $wpdb, $table_prefix;

    $result = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $table_prefix . "island_lots
        WHERE consumer_id =" . $id_item));

    return $object = array(
        'code' => 200,
        'result' => $result
    );
}

function accept_public_island_lot(WP_REST_Request $request)
{
    global $wpdb, $table_prefix;
    $lot_id = (int)$request['lot_id'];
    $consumer_id = (int)$request['consumer_id'];

    $result = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $table_prefix . "island_lots
        WHERE id =" . $lot_id . " and consumer_id = 0 and status = 'open'"));

    if(!$result) {
        return $object = array(
            'code' => 200,
            'result' => "no public deals"
        );
    }

    $lot_items = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $table_prefix . "island_lots WHERE id = " . $lot_id . " ORDER BY id "));

    $island_consumer_items = json_decode($lot_items[0]->consumer_items);
    $creator_id = $lot_items[0]->creator_id;
    $island_creator_items = json_decode($lot_items[0]->creator_items);

    return extracted($result, $consumer_id, $island_consumer_items, $creator_id, $island_creator_items, $wpdb, $table_prefix, $lot_id);
}

function accept_private_island_lot(WP_REST_Request $request)
{
    global $wpdb, $table_prefix;
    $lot_id = (int)$request['lot_id'];

    $result = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $table_prefix . "island_lots
        WHERE id =" . $lot_id . " and status ='open'"));

    $lot_items = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $table_prefix . "island_lots WHERE id = " . $lot_id . " ORDER BY id "));

    $island_consumer_items = json_decode($lot_items[0]->consumer_items);
    $creator_id = $lot_items[0]->creator_id;
    $island_creator_items = json_decode($lot_items[0]->creator_items);
    $consumer_id = $lot_items[0]->consumer_id;

    return extracted($result, $consumer_id, $island_consumer_items, $creator_id, $island_creator_items, $wpdb, $table_prefix, $lot_id);
}

/**
 * @param $result
 * @param $consumer_id
 * @param $island_consumer_items
 * @param $creator_id
 * @param $island_creator_items
 * @param wpdb $wpdb
 * @param string $table_prefix
 * @param int $lot_id
 * @return array
 */
function extracted($result, $consumer_id, $island_consumer_items, $creator_id, $island_creator_items, wpdb $wpdb, string $table_prefix, int $lot_id): array
{
    if (!empty($result)) {
        if (!checkUser($consumer_id) || !checkUserItems($consumer_id, $island_consumer_items)) {
            return $object = array(
                'code' => 200,
                'result' => "please check consumer items"
            );
        }

        if (!checkUser($creator_id) || !checkUserItems($creator_id, $island_creator_items)) {
            return $object = array(
                'code' => 200,
                'result' => "please check creator items"
            );
        }
    }

    $result = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $table_prefix . "island_items"));

    $consumer_items_id = [];
    $creator_items_id = [];

    foreach ($island_consumer_items->items as $island_consumer_item) {
        foreach ($result as $res) {
            if ($island_consumer_item === $res->name) {
                $consumer_items_id[] = $res->id;
            }
        }
    }

    foreach ($consumer_items_id as $consumer_item) {
        $wpdb->get_results($wpdb->prepare("UPDATE `" . $table_prefix . "island_user_items` SET id_user = " . $creator_id . " WHERE id_item = " . $consumer_item . " and id_user = " . $consumer_id . " LIMIT 1"));
    }

    foreach ($island_creator_items->items as $island_creator_item) {
        foreach ($result as $res) {
            if ($island_creator_item === $res->name) {
                $creator_items_id[] = $res->id;
            }
        }
    }

    foreach ($creator_items_id as $creator_item) {
        $result = $wpdb->get_results($wpdb->prepare("UPDATE `" . $table_prefix . "island_user_items` SET id_user = " . $consumer_id . " WHERE id_item = " . $creator_item . " and id_user = " . $creator_id . " LIMIT 1"));
    }

    $wpdb->update($table_prefix . "island_lots", array(
        'status' => 'close',
        'consumer_id' => $consumer_id
    ), array(
        'id' => $lot_id
    ));

    return $object = array(
        'code' => 200,
        'result' => "deal is successful"
    );
}
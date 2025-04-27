<?php
require_once 'connect.php';

if (isset($_POST['add_form'])) {
    $room_no = $_POST['room_no'];
    $days = $_POST['days'];
    $extra_bed = $_POST['extra_bed'];
    $transaction_id = $_POST['transaction_id'];

    // Check if the room is already booked
    $query = $conn->query("SELECT * FROM `transaction` WHERE `room_no` = '$room_no' AND `status` = 'Check In' LIMIT 1");
    $row = $query->num_rows;
    $time = date("H:i:s", strtotime("+8 HOURS"));

    if ($row > 0) {
        echo "<script>alert('Room not available'); window.location.href='confirm_reserve.php?transaction_id=$transaction_id';</script>";
        exit();
    }

    // Fetch transaction details
    $query2 = $conn->query("SELECT * FROM `transaction` 
                            NATURAL JOIN `guest` 
                            NATURAL JOIN `room` 
                            WHERE `transaction_id` = '$transaction_id'");

    if ($query2->num_rows > 0) {
        $fetch2 = $query2->fetch_array();
        $total = $fetch2['price'] * $days;
        $total2 = 800 * $extra_bed;
        $total3 = $total + $total2;
        $checkout = date("Y-m-d", strtotime($fetch2['checkin']."+".$days." DAYS"));

        // Start Transaction
        $conn->begin_transaction();
        try {
            $conn->query("UPDATE `transaction` 
                          SET `room_no` = '$room_no', 
                              `days` = '$days', 
                              `extra_bed` = '$extra_bed', 
                              `status` = 'Check In', 
                              `checkin_time` = '$time', 
                              `checkout` = '$checkout', 
                              `bill` = '$total3' 
                          WHERE `transaction_id` = '$transaction_id'");

            $conn->commit();
            header("location:checkin.php");
            exit();
        } catch (Exception $e) {
            $conn->rollback();
            die("Error: " . $e->getMessage());
        }
    } else {
        die("Transaction ID not found!");
    }
}
?>

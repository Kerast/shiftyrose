<?php require('PaypalIPN.php');


$dbusername = "kerast";
$dbpassword = "JbbC1787*$";
$dbname = "shiftyrose";
$dbadress = "localhost";



use PaypalIPN;



$ipn = new PayPalIPN();

// Use the sandbox endpoint during testing.
$ipn->useSandbox();
$verified = $ipn->verifyIPN();
//$verified = true;
if ($verified) {
    /*
     * Process IPN
     * A list of variables is available here:
     * https://developer.paypal.com/webapps/developer/docs/classic/ipn/integration-guide/IPNandPDTVariables/
     */

    $item_name = $_POST['item_name'];
    $item_number = $_POST['item_number'];
    $payment_status = $_POST['payment_status'];
    $payment_amount = $_POST['mc_gross'];
    $payment_currency = $_POST['mc_currency'];
    $txn_id = $_POST['txn_id'];
    $receiver_email = $_POST['receiver_email'];
    $payer_email = $_POST['payer_email'];
    $cust = $_POST['custom'];

    //transsac
    $bdd = new PDO('mysql:host='. $dbadress .';dbname='.$dbname.';charset=utf8', $dbusername, $dbpassword);
    $response = $bdd->prepare('INSERT INTO payment_transaction (itemName, itemNumber, paymentStatus, mcGross, paypalTransactionId, payerEmail, user_id)
										VALUES (?, ?, ?, ?, ?, ?, ?)');
    $response->execute([$item_name, $item_number, $payment_status, $payment_amount, $txn_id, $payer_email, $cust]);
    $response->closeCursor();


    //on donne
    $bdd = new PDO('mysql:host='. $dbadress .';dbname='.$dbname.';charset=utf8', $dbusername, $dbpassword);
    $stmt = $bdd->prepare("SELECT * FROM fos_user WHERE id=:id");
    $stmt->bindValue("id", 1, PDO::PARAM_INT);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $user = $rows[0];


    $bdd = new PDO('mysql:host='. $dbadress .';dbname='.$dbname.';charset=utf8', $dbusername, $dbpassword);
    $stmt = $bdd->prepare("SELECT * FROM plex_package WHERE id=?");
    $stmt->bindValue(1, 1, PDO::PARAM_INT);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $selectedPackage = $rows[0];


    $bdd = new PDO('mysql:host='. $dbadress .';dbname='.$dbname.';charset=utf8', $dbusername, $dbpassword);
    $stmt = $bdd->prepare("UPDATE fos_user SET virtual_money_balance=:vmb WHERE id=:id");
    $stmt->bindValue("id", intval($cust), PDO::PARAM_INT);
    $stmt->bindValue("vmb", (intval($user["virtual_money_balance"] + $selectedPackage["plex"])), PDO::PARAM_INT);
    $stmt->execute();


}
else
{
    $item_name = $_POST['item_name'];
    $item_number = $_POST['item_number'];
    $payment_status = $_POST['payment_status'];
    $payment_amount = $_POST['mc_gross'];
    $payment_currency = $_POST['mc_currency'];
    $txn_id = $_POST['txn_id'];
    $receiver_email = $_POST['receiver_email'];
    $payer_email = $_POST['payer_email'];
    $cust = $_POST['custom'];

    //transsac
    $bdd = new PDO('mysql:host='. $dbadress .';dbname='.$dbname.';charset=utf8', $dbusername, $dbpassword);
    $response = $bdd->prepare('INSERT INTO payment_transaction (itemName, itemNumber, paymentStatus, mcGross, paypalTransactionId, payerEmail, user_id)
										VALUES (?, ?, ?, ?, ?, ?, ?)');
    $response->execute([$item_name, $item_number, $payment_status, $payment_amount, $txn_id, $payer_email, $cust]);
    $response->closeCursor();
}



// Reply with an empty 200 response to indicate to paypal the IPN was received correctly.
header("HTTP/1.1 200 OK");

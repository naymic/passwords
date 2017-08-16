<?php
session_start();

include_once 'vendor/autoload.php';
include 'Control.php';
include 'Vision.php';
include 'Pages.php';

include 'MClasses.php';
include 'ItemToStore.php';
include 'AdapterVision.php';
include 'Hashtable.php';
include 'Error.php';
include 'Store.php';
include 'User.php';
include 'UserLog.php';
include 'Login.php';
include './storage/dao.php';
include './storage/model.php';
include './storage/stUser.php';
include './storage/stLogin.php';
include './storage/stUserLog.php';
include 'Mapper.php';

include 'utils/CryptPass.php';
include 'utils/StringUtils.php';

include 'Connect.php';
include "UserST.php";
include "LoginST.php";
include "UserLogST.php";



/*
$className = 'stUser';

$stUser = new $className();
print_r($stUser);


/*
$stUser->password = "jkjkljç";
$stUser->username = "Micha";
$reflector = new ReflectionClass($stUser);
$props   = $reflector->getProperties();
foreach ($props as $value){
	echo "<br>".$value->getName();
	echo "<br>".$reflector->getProperty($value->getName())->getValue($stUser);
	echo "<br>".$reflector->getProperty($value->getName())->getDocComment();
	if(is_numeric(strpos($reflector->getProperty($value->getName())->getDocComment(), strtolower('PK'))))
		echo "<br>Is a PK";
}*/


	


/*
$stUser->id = 28;
$object = $dao->selectAll($stUser);

print_r($object);
*/

$adapterVision = AdapterVision::getInstance();

$adapterVision->showPage();


/*
$cp = new CryptPass();

$word = "Z123456789";
echo "<br>". $word;

$crypt = $cp->crypt($word);
echo "<br>". $crypt;

$uncrypt = $cp->unCrypt($crypt);
echo "<br>". $uncrypt;


$word = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
echo "<br>". $word;

$crypt = $cp->crypt($word);
echo "<br>". $crypt;

$uncrypt = $cp->unCrypt($crypt);
*/

?>
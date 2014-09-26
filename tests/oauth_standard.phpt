--TEST--
OAuth Standard functions
--FILE--
<?php
require '../OAuth.php';

function oauth_dump($v)
{
	if (is_null($v)) {
		echo "NULL\n";
		return;
	}
	if ($v instanceof OAuth) {
		printf("OAuth[debug=%d,sslChecks=%d,debugInfo=%s]\n", $v->debug, $v->sslChecks, $v->debugInfo);
		return;
	}
	echo "NOT_OAUTH\n";
}

echo "-- empty params --\n";
$x = null;
try {
$x = new OAuth;
} catch (Exception $E) {
echo "EXCEPTION {$E->getCode()}: {$E->getMessage()}\n";
}
oauth_dump($x);
echo "-- one param --\n";
$x = null;
try {
$x = new OAuth('');
} catch (Exception $E) {
echo "EXCEPTION {$E->getCode()}: {$E->getMessage()}\n";
}
oauth_dump($x);
echo "-- empty consumer key and secret --\n";
$x = null;
try {
	$x = new OAuth('', '');
} catch (Exception $e) {
	echo "EXCEPTION {$e->getCode()}: {$e->getMessage()}\n";
}
oauth_dump($x);
echo "-- empty consumer secret --\n";
try {
	$x = new OAuth('1234', '');
} catch (Exception $e) {
	echo "EXCEPTION {$e->getCode()}: {$e->getMessage()}\n";
}
oauth_dump($x);

echo "-- normal constructor --\n";
$x = new OAuth('1234', '5678');
oauth_dump($x);

echo "-- enable debug --\n";
$x->enableDebug();
oauth_dump($x);

echo "-- disable debug --\n";
$x->disableDebug();
oauth_dump($x);

try {
	echo "-- set version without parameters --\n";
	var_dump($x->setVersion());
} catch (Exception $e) {
	echo "EXCEPTION {$e->getCode()}: {$e->getMessage()}\n";
}
try {
	echo "-- set version with boolean --\n";
	var_dump($x->setVersion(true));
} catch (Exception $e) {
	echo "EXCEPTION {$e->getCode()}: {$e->getMessage()}\n";
}

try {
	echo "-- set version with empty string --\n";
	var_dump($x->setVersion(''));
} catch (Exception $e) {
	echo "EXCEPTION {$e->getCode()}: {$e->getMessage()}\n";
}

echo "-- set version to 1 --\n";
var_dump($x->setVersion('1'));

try {
	echo "-- set auth type to invalid type 99 --\n";
	var_dump($x->setAuthType(99));
} catch (Exception $e) {
	echo "EXCEPTION {$e->getCode()}: {$e->getMessage()}\n";
}

echo "-- generate a signature --\n";
var_dump(is_string($x->generateSignature('GET', 'http://www.friendface.com/foo', array('param' => 'value'))));

echo "-- set a timeout (100 ms) --\n";
var_dump($x->setTimeout(100));

echo "-- set an invalid timeout --\n";
try {
$x->setTimeout(-1);
} catch (Exception $E) {
echo "EXCEPTION {$E->getCode()}: {$E->getMessage()}\n";
}
?>
--EXPECTF--
-- empty params --

Warning: Missing argument 1 for OAuth::__construct(), called in %s

Warning: Missing argument 2 for OAuth::__construct(), called in %s
EXCEPTION -1: The consumer key cannot be empty
NULL
-- one param --

Warning: Missing argument 2 for OAuth::__construct(), called in %s
EXCEPTION -1: The consumer key cannot be empty
NULL
-- empty consumer key and secret --
EXCEPTION -1: The consumer key cannot be empty
NULL
-- empty consumer secret --
OAuth[debug=0,sslChecks=3,debugInfo=]
-- normal constructor --
OAuth[debug=0,sslChecks=3,debugInfo=]
-- enable debug --
OAuth[debug=1,sslChecks=3,debugInfo=]
-- disable debug --
OAuth[debug=0,sslChecks=3,debugInfo=]
-- set version without parameters --

Warning: OAuth::setVersion() expects exactly 1 parameter, 0 given %s
NULL
-- set version with boolean --
bool(true)
-- set version with empty string --
EXCEPTION 503: Invalid version
-- set version to 1 --
bool(true)
-- set auth type to invalid type 99 --
EXCEPTION 503: Invalid auth type
-- generate a signature --
bool(true)
-- set a timeout (100 ms) --
bool(true)
-- set an invalid timeout --
EXCEPTION 503: Invalid timeout

<?php


include __DIR__ . '/../vendor/autoload.php';

include __DIR__ . '/../vendor/granadaorm/granada/src/Granada/ORM.php';
include __DIR__ . '/../vendor/granadaorm/granada/src/Granada/Orm/Wrapper.php';
include __DIR__ . '/../vendor/granadaorm/granada/src/Granada/Orm/Str.php';
include __DIR__ . '/../vendor/granadaorm/granada/src/Granada/Granada.php';
include __DIR__ . '/../vendor/granadaorm/granada/src/Granada/Model.php';
include __DIR__ . '/../vendor/granadaorm/granada/src/Granada/Eager.php';
include __DIR__ . '/../vendor/granadaorm/granada/src/Granada/ResultSet.php';

// Handle both PHP5 and PHP7 tests
if (!class_exists('\PHPUnit_Framework_TestCase') && class_exists('\PHPUnit\Framework\TestCase'))
    class_alias('\PHPUnit\Framework\TestCase', '\PHPUnit_Framework_TestCase');

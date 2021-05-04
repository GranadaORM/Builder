<?php

/**
 * This is the base model class for the database table 'datatype_test'
 *
 * Do not modify this file, it is overwritten via the granadabuilder script
 */

namespace MyAppTest;

/**
 *
 * @method string[] find_pairs_representation(integer $limit) List of items in an array using the representation string
 * @method array find_pairs(string|null $key, string|null $value) Gets data in array form, as pairs of data for each row in the results. The key and value are the database column to use as the array keys and values
 * @method boolean delete_many() Delete all matching records
 * @method integer count(string $column) Get the count of the column
 * @method string max(string $column) Will return the max value of the chosen column.
 * @method string min(string $column) Will return the min value of the chosen column.
 * @method string avg(string $column) Will return the average value of the chosen column.
 * @method string sum(string $column) Will return the sum of the values of the chosen column.
 * @method \MyAppTest\DatatypeTest find_one(integer $id) Find one matching record. If $id is set, get the pk record
 * @method \MyAppTest\DatatypeTest[] find_many() Find all matching records
 * @method \MyAppTest\QueryDatatypeTest raw_query(string $query, array $parameters) Perform a raw query. The query can contain placeholders in either named or question mark style. If placeholders are used, the parameters should be an array of values which will be bound to the placeholders in the query. If this method is called, all other query building methods will be ignored.
 * @method \MyAppTest\QueryDatatypeTest table_alias(string $alias) Add an alias for the main table to be used in SELECT queries
 * @method \MyAppTest\QueryDatatypeTest select(string $column, string $alias) Add a column to the list of columns returned by the SELECT query. This defaults to '*'. The second optional argument is the alias to return the column as.
 * @method \MyAppTest\QueryDatatypeTest select_expr(string $expr, string $alias) Add an unquoted expression to the list of columns returned by the SELECT query. The second optional argument is the alias to return the column as.
 * @method \MyAppTest\QueryDatatypeTest distinct() Add a DISTINCT keyword before the list of columns in the SELECT query
 * @method \MyAppTest\QueryDatatypeTest join(string $table, string $constraint, string $table_alias) Add a simple JOIN source to the query
 * @method \MyAppTest\QueryDatatypeTest inner_join(string $table, string[] $constraint, string) Add an INNER JOIN source to the query
 * @method \MyAppTest\QueryDatatypeTest left_outer_join(string $table, string[] $constraint, string $table_alias) Add a LEFT OUTER JOIN source to the query
 * @method \MyAppTest\QueryDatatypeTest limit(integer $number)Add a LiMiT to the query
 * @method \MyAppTest\QueryDatatypeTest offset(integer $offset) Add an OFFSET to the query
 * @method \MyAppTest\QueryDatatypeTest group_by(string $column_name) Add a column to the list of columns to GROUP BY
 * @method \MyAppTest\QueryDatatypeTest group_by_expr(string $expr) Add an unquoted expression to the list of columns to GROUP BY
 * @method \MyAppTest\QueryDatatypeTest having(string $column_name, string $value) Add a HAVING column = value clause to your query. Each time this is called in the chain, an additional HAVING will be added, and these will be ANDed together when the final query is built.
 * @method \MyAppTest\QueryDatatypeTest having_equal(string $column_name, string $value) More explicitly named version of for the having() method. Can be used if preferred.
 * @method \MyAppTest\QueryDatatypeTest having_not_equal(string $column_name, string $value) Add a HAVING column != value clause to your query.
 * @method \MyAppTest\QueryDatatypeTest having_id_is(integer $id) Special method to query the table by its primary key
 * @method \MyAppTest\QueryDatatypeTest having_like(string $column_name, string $value) Add a HAVING ... LIKE clause to your query.
 * @method \MyAppTest\QueryDatatypeTest having_not_like(string $column_name, string $value) Add where HAVING ... NOT LIKE clause to your query.
 * @method \MyAppTest\QueryDatatypeTest having_gt(string $column_name, integer $value) Add a HAVING ... > clause to your query
 * @method \MyAppTest\QueryDatatypeTest having_lt(string $column_name, string $value) Add a HAVING ... < clause to your query
 * @method \MyAppTest\QueryDatatypeTest having_gte(string $column_name, string $value) Add a HAVING ... >= clause to your query
 * @method \MyAppTest\QueryDatatypeTest having_lte(string $column_name, string $value) Add a HAVING ... <= clause to your query
 * @method \MyAppTest\QueryDatatypeTest having_in(string $column_name, string[] $values) Add a HAVING ... IN clause to your query
 * @method \MyAppTest\QueryDatatypeTest having_not_in(string $column_name, string[] $values) Add a HAVING ... NOT IN clause to your query
 * @method \MyAppTest\QueryDatatypeTest having_null(string $column_name) Add a HAVING column IS NULL clause to your query
 * @method \MyAppTest\QueryDatatypeTest having_not_null(string $column_name) Add a HAVING column IS NOT NULL clause to your query
 * @method \MyAppTest\QueryDatatypeTest having_raw(string $clause, string[] $parameters) Add a raw HAVING clause to the query. The clause should contain question mark placeholders, which will be bound to the parameters supplied in the second argument.
 * @method \MyAppTest\QueryDatatypeTest where_id(string $value) Add a WHERE id = clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_id_not_equal(string $value) Add a WHERE id != clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_id_like(string $value) Add a WHERE id LIKE clause to your query.
 * @method \MyAppTest\QueryDatatypeTest where_id_not_like(string $value) Add where WHERE id NOT LIKE clause to your query.
 * @method \MyAppTest\QueryDatatypeTest where_id_gt(string $value) Add a WHERE id > clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_id_lt(string $value) Add a WHERE id < clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_id_gte(string $value) Add a WHERE id >= clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_id_lte(string $value) Add a WHERE id <= clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_id_gt_or_null(string $value) Add a WHERE id > clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_id_lt_or_null(string $value) Add a WHERE id < clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_id_gte_or_null(string $value) Add a WHERE id >= clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_id_lte_or_null(string $value) Add a WHERE id <= clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_id_in(string $values) Add a WHERE id IN clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_id_not_in(string[] $values) Add a WHERE id NOT IN clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_id_null() Add a WHERE id IS NULL clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_id_not_null() Add a WHERE id IS NOT NULL clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_json(string $value) Add a WHERE data_json = clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_json_not_equal(string $value) Add a WHERE data_json != clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_json_like(string $value) Add a WHERE data_json LIKE clause to your query.
 * @method \MyAppTest\QueryDatatypeTest where_data_json_not_like(string $value) Add where WHERE data_json NOT LIKE clause to your query.
 * @method \MyAppTest\QueryDatatypeTest where_data_json_gt(string $value) Add a WHERE data_json > clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_json_lt(string $value) Add a WHERE data_json < clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_json_gte(string $value) Add a WHERE data_json >= clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_json_lte(string $value) Add a WHERE data_json <= clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_json_gt_or_null(string $value) Add a WHERE data_json > clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_json_lt_or_null(string $value) Add a WHERE data_json < clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_json_gte_or_null(string $value) Add a WHERE data_json >= clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_json_lte_or_null(string $value) Add a WHERE data_json <= clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_json_in(string $values) Add a WHERE data_json IN clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_json_not_in(string[] $values) Add a WHERE data_json NOT IN clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_json_null() Add a WHERE data_json IS NULL clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_json_not_null() Add a WHERE data_json IS NOT NULL clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_serialize(string $value) Add a WHERE data_serialize = clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_serialize_not_equal(string $value) Add a WHERE data_serialize != clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_serialize_like(string $value) Add a WHERE data_serialize LIKE clause to your query.
 * @method \MyAppTest\QueryDatatypeTest where_data_serialize_not_like(string $value) Add where WHERE data_serialize NOT LIKE clause to your query.
 * @method \MyAppTest\QueryDatatypeTest where_data_serialize_gt(string $value) Add a WHERE data_serialize > clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_serialize_lt(string $value) Add a WHERE data_serialize < clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_serialize_gte(string $value) Add a WHERE data_serialize >= clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_serialize_lte(string $value) Add a WHERE data_serialize <= clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_serialize_gt_or_null(string $value) Add a WHERE data_serialize > clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_serialize_lt_or_null(string $value) Add a WHERE data_serialize < clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_serialize_gte_or_null(string $value) Add a WHERE data_serialize >= clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_serialize_lte_or_null(string $value) Add a WHERE data_serialize <= clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_serialize_in(string $values) Add a WHERE data_serialize IN clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_serialize_not_in(string[] $values) Add a WHERE data_serialize NOT IN clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_serialize_null() Add a WHERE data_serialize IS NULL clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_serialize_not_null() Add a WHERE data_serialize IS NOT NULL clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_string(string $value) Add a WHERE data_string = clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_string_not_equal(string $value) Add a WHERE data_string != clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_string_like(string $value) Add a WHERE data_string LIKE clause to your query.
 * @method \MyAppTest\QueryDatatypeTest where_data_string_not_like(string $value) Add where WHERE data_string NOT LIKE clause to your query.
 * @method \MyAppTest\QueryDatatypeTest where_data_string_gt(string $value) Add a WHERE data_string > clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_string_lt(string $value) Add a WHERE data_string < clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_string_gte(string $value) Add a WHERE data_string >= clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_string_lte(string $value) Add a WHERE data_string <= clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_string_gt_or_null(string $value) Add a WHERE data_string > clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_string_lt_or_null(string $value) Add a WHERE data_string < clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_string_gte_or_null(string $value) Add a WHERE data_string >= clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_string_lte_or_null(string $value) Add a WHERE data_string <= clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_string_in(string $values) Add a WHERE data_string IN clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_string_not_in(string[] $values) Add a WHERE data_string NOT IN clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_string_null() Add a WHERE data_string IS NULL clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_data_string_not_null() Add a WHERE data_string IS NOT NULL clause to your query
 * @method \MyAppTest\QueryDatatypeTest where_raw(string $clause, array $parameters = NULL) Add a raw WHERE clause to the query. The clause should contain question mark placeholders, which will be bound to the parameters supplied in the second argument.
 * @method \MyAppTest\QueryDatatypeTest with(string $name) Eager-load data from another table
 * @method \MyAppTest\QueryDatatypeTest defaultFilter() Add a query to get default filter. Use as $items = DatatypeTest::model()->defaultFilter()->find_many();
 * @method \MyAppTest\QueryDatatypeTest order_by_id_asc() Add an ORDER BY column ASC clause for id
 * @method \MyAppTest\QueryDatatypeTest order_by_id_desc() Add an ORDER BY column DESC clause for id
 * @method \MyAppTest\QueryDatatypeTest order_by_id_natural_asc() Add an ORDER BY column ASC clause using natural sorting method for id
 * @method \MyAppTest\QueryDatatypeTest order_by_id_natural_desc() Add an ORDER BY column DESC clause using natural sorting method for id
 * @method \MyAppTest\QueryDatatypeTest order_by_data_json_asc() Add an ORDER BY column ASC clause for data_json
 * @method \MyAppTest\QueryDatatypeTest order_by_data_json_desc() Add an ORDER BY column DESC clause for data_json
 * @method \MyAppTest\QueryDatatypeTest order_by_data_json_natural_asc() Add an ORDER BY column ASC clause using natural sorting method for data_json
 * @method \MyAppTest\QueryDatatypeTest order_by_data_json_natural_desc() Add an ORDER BY column DESC clause using natural sorting method for data_json
 * @method \MyAppTest\QueryDatatypeTest order_by_data_serialize_asc() Add an ORDER BY column ASC clause for data_serialize
 * @method \MyAppTest\QueryDatatypeTest order_by_data_serialize_desc() Add an ORDER BY column DESC clause for data_serialize
 * @method \MyAppTest\QueryDatatypeTest order_by_data_serialize_natural_asc() Add an ORDER BY column ASC clause using natural sorting method for data_serialize
 * @method \MyAppTest\QueryDatatypeTest order_by_data_serialize_natural_desc() Add an ORDER BY column DESC clause using natural sorting method for data_serialize
 * @method \MyAppTest\QueryDatatypeTest order_by_data_string_asc() Add an ORDER BY column ASC clause for data_string
 * @method \MyAppTest\QueryDatatypeTest order_by_data_string_desc() Add an ORDER BY column DESC clause for data_string
 * @method \MyAppTest\QueryDatatypeTest order_by_data_string_natural_asc() Add an ORDER BY column ASC clause using natural sorting method for data_string
 * @method \MyAppTest\QueryDatatypeTest order_by_data_string_natural_desc() Add an ORDER BY column DESC clause using natural sorting method for data_string
 * @method \MyAppTest\QueryDatatypeTest order_by_rand() Fetch items in a random order. Use sparingly and ensure a LIMIT is placed
 * @method \MyAppTest\QueryDatatypeTest order_by_expr(string $clause) Add an unquoted expression as an ORDER BY clause
 * @method \MyAppTest\QueryDatatypeTest order_by_list(string $column_name, integer[] $list) Add an ORDER BY FIELD column clause to make the ordering a specific sequence
 * @method \MyAppTest\QueryDatatypeTest defaultFilter()
 * @method \MyAppTest\QueryDatatypeTest onlyif(bool $condition, callable $query) Add a WHERE, ORDER BY or LIMIT clause only if the condition is true
 */

abstract class QueryDatatypeTest extends \MyAppTest\ORMBaseClass {
}

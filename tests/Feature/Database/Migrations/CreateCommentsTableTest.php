<?php

namespace Tests\Feature\Database\Migrations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CreateCommentsTableTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Table name.
     */
    protected $table = 'comments';

    /**
     * Columns, names and types.
     */
    protected $columns = [
        'id' => 'INTEGER',
        'user_id' => 'INTEGER',
        'post_id' => 'INTEGER',
        'body' => 'TEXT',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Primary key name.
     */
    protected $primary_key = 'id';

    /**
     * Foreign keys.
     */
    protected $foreign_keys = [
        0 => [
            'table' => 'posts',
            'from' => 'post_id',
            'to' => 'id',
            'on_update' => 'NO ACTION',
            'on_delete' => 'CASCADE',
        ],
        1 => [
            'table' => 'users',
            'from' => 'user_id',
            'to' => 'id',
            'on_update' => 'NO ACTION',
            'on_delete' => 'RESTRICT',
        ],
    ];

    /**
     * Comments table exists.
     */
    public function test_comments_table_exists()
    {
        $this->assertTrue(Schema::hasTable($this->table));
    }

    /**
     * Comments table has correct column names.
     */
    public function test_comments_table_has_correct_column_names()
    {
        $column_names = [];

        foreach ($this->columns as $key => $value) {
            $column_names[] = $key;
        }

        $colmnn_names = array_values($column_names);

        $this->assertTrue(Schema::hasColumns($this->table, $colmnn_names));
    }

    /**
     * Comments table has correct column names.
     */
    public function test_comments_table_has_correct_column_types()
    {
        $column_types = DB::select(
            DB::raw("PRAGMA table_info($this->table)")->getValue(DB::connection()->getQueryGrammar())
        );

        foreach ($column_types as $key => $value) {
            $this->assertEquals($value->type, $this->columns[$value->name]);
        }
    }

    /**
     * Comments table has primary key.
     */
    public function test_comments_table_has_primary_key()
    {
        $primary_keys = DB::select(
            DB::raw("PRAGMA table_info($this->table)")->getValue(DB::connection()->getQueryGrammar())
        );

        foreach ($primary_keys as $key => $value) {
            if ($value->name === $this->primary_key) {
                $this->assertEquals(1, $value->pk);
            }
        }
    }

    /**
     * Comments table has foreign keys.
     */
    public function test_comments_table_has_foreign_keys()
    {
        $foreignKeys = DB::select(
            DB::raw("PRAGMA foreign_key_list($this->table)")->getValue(DB::connection()->getQueryGrammar())
        );

        foreach ($this->foreign_keys as $count => $foreign_key) {
            foreach ($foreign_key as $property => $value) {
                $this->assertEquals($value, $foreignKeys[$count]->$property);
            }
        }
    }
}

<?php

namespace Tests\Feature\Database\Migrations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CreatePostsTableTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Table name.
     */
    protected $table = 'posts';

    /**
     * Columns, names and types.
     */
    protected $columns = [
        'id',
        'user_id', 
        'title',
        'slug',
        'description',
        'body',
        'created_at',
        'updated_at',
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
            'table' => 'users',
            'from' =>  'user_id',
            'to' => 'id',
            'on_update' => 'NO ACTION',
            'on_delete' => 'RESTRICT',
        ],
    ];

    /**
     * Indexes.
     */
    protected $indexes = [
        0 => 'slug',
    ];

    /**
     * Test posts table exists.
     */
    public function test_posts_table_exists()
    {
        $this->assertTrue(Schema::hasTable($this->table));
    }

    /**
     * Test posts table has correct column names.
     */
    public function test_posts_table_has_correct_column_names()
    {
        $this->assertTrue(Schema::hasColumns($this->table, $this->columns));
    }

    /**
     * Test comments table has primary key.
     */
    public function test_posts_table_has_primary_key()
    {
        $primary_keys = DB::select(
            DB::raw("PRAGMA table_info($this->table)")->getValue(DB::connection()->getQueryGrammar()) 
        );
    
        foreach ($primary_keys as $key => $value) {
            if ($value->name == $this->primary_key) {
                $this->assertEquals(1, $value->pk);
            }
        }
    }

    /**
     * Test posts table has foreign keys.
     */
    public function test_posts_table_has_foreign_keys()
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

    /**
     * Test posts table has unique indexes.
     */
    public function test_posts_table_has_unique_indexes()
    {
        $indexes = DB::select(
            DB::raw("PRAGMA index_list($this->table)")->getValue(DB::connection()->getQueryGrammar()) 
        );

        foreach ($this->indexes as $count => $index) {
            $this->assertEquals($this->table."_".$index."_unique", $indexes[$count]->name);
        }
    }
}

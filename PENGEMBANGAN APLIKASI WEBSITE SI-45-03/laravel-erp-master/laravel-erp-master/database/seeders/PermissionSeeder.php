<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create([
            'name' => 'Dashboard'
        ]);

        Permission::create([
            'name' => 'Role Index'
        ]);
        Permission::create([
            'name' => 'Role Create'
        ]);
        Permission::create([
            'name' => 'Role Edit'
        ]);
        Permission::create([
            'name' => 'Role Delete'
        ]);

        Permission::create([
            'name' => 'Permission Index'
        ]);
        Permission::create([
            'name' => 'Permission Create'
        ]);
        Permission::create([
            'name' => 'Permission Edit'
        ]);
        Permission::create([
            'name' => 'Permission Delete'
        ]);

        Permission::create([
            'name' => 'User Index'
        ]);
        Permission::create([
            'name' => 'User Create'
        ]);
        Permission::create([
            'name' => 'User Edit'
        ]);
        Permission::create([
            'name' => 'User Delete'
        ]);

        // pemasukan
        Permission::create([
            'name' => 'Pemasukan Index'
        ]);
        Permission::create([
            'name' => 'Pemasukan Create'
        ]);
        Permission::create([
            'name' => 'Pemasukan Edit'
        ]);
        Permission::create([
            'name' => 'Pemasukan Delete'
        ]);

        // Pengeluaran
        Permission::create([
            'name' => 'Pengeluaran Index'
        ]);
        Permission::create([
            'name' => 'Pengeluaran Create'
        ]);
        Permission::create([
            'name' => 'Pengeluaran Edit'
        ]);
        Permission::create([
            'name' => 'Pengeluaran Delete'
        ]);

        // Kategori
        Permission::create([
            'name' => 'Kategori Index'
        ]);
        Permission::create([
            'name' => 'Kategori Create'
        ]);
        Permission::create([
            'name' => 'Kategori Edit'
        ]);
        Permission::create([
            'name' => 'Kategori Delete'
        ]);

        // Produk
        Permission::create([
            'name' => 'Produk Index'
        ]);
        Permission::create([
            'name' => 'Produk Create'
        ]);
        Permission::create([
            'name' => 'Produk Edit'
        ]);
        Permission::create([
            'name' => 'Produk Delete'
        ]);

        // Penjualan
        Permission::create([
            'name' => 'Penjualan Index'
        ]);
        Permission::create([
            'name' => 'Penjualan Create'
        ]);
        Permission::create([
            'name' => 'Penjualan Edit'
        ]);
        Permission::create([
            'name' => 'Penjualan Delete'
        ]);

        // Supplier
        Permission::create([
            'name' => 'Supplier Index'
        ]);
        Permission::create([
            'name' => 'Supplier Create'
        ]);
        Permission::create([
            'name' => 'Supplier Edit'
        ]);
        Permission::create([
            'name' => 'Supplier Delete'
        ]);

        // Produk Supplier
        Permission::create([
            'name' => 'Produk Supplier Index'
        ]);
        Permission::create([
            'name' => 'Produk Supplier Create'
        ]);
        Permission::create([
            'name' => 'Produk Supplier Edit'
        ]);
        Permission::create([
            'name' => 'Produk Supplier Delete'
        ]);


        // Project
        Permission::create([
            'name' => 'Project Index'
        ]);
        Permission::create([
            'name' => 'Project Create'
        ]);
        Permission::create([
            'name' => 'Project Edit'
        ]);
        Permission::create([
            'name' => 'Project Delete'
        ]);
    }
}

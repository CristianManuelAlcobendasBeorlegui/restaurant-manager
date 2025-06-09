<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tables')->insert([
            [
            "id" => "1",
            "status" => "available",
            "max_guests" => 8,
            "guests" => 1,
            "code" => null,
            "data" => json_encode([ "x" => "38.80952380952374","y" => "71.57142857142856","width" => "278.19047619047626","height" => "160.42857142857144"] ),
            "handle" => json_encode([ "cx" => "317","cy" => "232","r" => "5"] )
          ] , [
            "id" => "2",
            "status" => "available",
            "max_guests" => 8,
            "guests" => 1,
            "code" => null,
            "data" => json_encode([ "x" => "347.9999999999999","y" => "71.99999999999997","width" => "262","height" => "163.99999999999997"] ),
            "handle" => json_encode([ "cx" => "609.9999999999999","cy" => "235.99999999999994","r" => "5"] )
          ] , [
            "id" => "3",
            "status" => "available",
            "max_guests" => 8,
            "guests" => 1,
            "code" => null,
            "data" => json_encode([ "x" => "895.9999999999998","y" => "73.99999999999997","width" => "244","height" => "161.99999999999997"] ),
            "handle" => json_encode([ "cx" => "1139.9999999999998","cy" => "235.99999999999994","r" => "5"] )
          ] , [
            "id" => "4",
            "status" => "available",
            "max_guests" => 8,
            "guests" => 1,
            "code" => null,
            "data" => json_encode([ "x" => "1173.9999999999998","y" => "72","width" => "278","height" => "161.99999999999994"] ),
            "handle" => json_encode([ "cx" => "1451.9999999999998","cy" => "233.99999999999994","r" => "5"] )
          ] , [
            "id" => "5",
            "status" => "available",
            "max_guests" => 6,
            "guests" => 1,
            "code" => null,
            "data" => json_encode([ "x" => "43.99999999999997","y" => "323.9999999999999","width" => "223.99999999999997","height" => "142"] ),
            "handle" => json_encode([ "cx" => "267.99999999999994","cy" => "465.9999999999999","r" => "5"] )
          ] , [
            "id" => "6",
            "status" => "available",
            "max_guests" => 6,
            "guests" => 1,
            "code" => null,
            "data" => json_encode([ "x" => "44","y" => "493.9999999999999","width" => "211.99999999999994","height" => "140"] ),
            "handle" => json_encode([ "cx" => "255.99999999999994","cy" => "633.9999999999999","r" => "5"] )
          ] , [
            "id" => "7",
            "status" => "available",
            "max_guests" => 6,
            "guests" => 1,
            "code" => null,
            "data" => json_encode([ "x" => "50","y" => "667.9999999999998","width" => "201.99999999999994","height" => "132"] ),
            "handle" => json_encode([ "cx" => "251.99999999999994","cy" => "799.9999999999998","r" => "5"] )
          ] , [
            "id" => "8",
            "status" => "available",
            "max_guests" => 2,
            "guests" => 1,
            "code" => null,
            "data" => json_encode([ "x" => "1203.9999999999998","y" => "317.99999999999983","width" => "232","height" => "108"] ),
            "handle" => json_encode([ "cx" => "1435.9999999999998","cy" => "425.99999999999983","r" => "5"] )
          ] , [
            "id" => "9",
            "status" => "available",
            "max_guests" => 2,
            "guests" => 1,
            "code" => null,
            "data" => json_encode([ "x" => "1203.9999999999998","y" => "435.9999999999999","width" => "232","height" => "94"] ),
            "handle" => json_encode([ "cx" => "1435.9999999999998","cy" => "529.9999999999999","r" => "5"] )
          ] , [
            "id" => "10",
            "status" => "available",
            "max_guests" => 2,
            "guests" => 1,
            "code" => null,
            "data" => json_encode([ "x" => "1203.9999999999998","y" => "539.9999999999999","width" => "232","height" => "104"] ),
            "handle" => json_encode([ "cx" => "1435.9999999999998","cy" => "643.9999999999999","r" => "5"] )
          ] , [
            "id" => "11",
            "status" => "available",
            "max_guests" => 2,
            "guests" => 1,
            "code" => null,
            "data" => json_encode([ "x" => "1201.9999999999998","y" => "657.9999999999998","width" => "234","height" => "100.00000000000011"] ),
            "handle" => json_encode([ "cx" => "1435.9999999999998","cy" => "757.9999999999999","r" => "5"] )
          ] , [
            "id" => "12",
            "status" => "available",
            "max_guests" => 4,
            "guests" => 1,
            "code" => null,
            "data" => json_encode([ "x" => "387.9999999999999","y" => "311.9999999999999","width" => "126","height" => "132"] ),
            "handle" => json_encode([ "cx" => "513.9999999999999","cy" => "443.9999999999999","r" => "5"] )
          ] , [
            "id" => "13",
            "status" => "available",
            "max_guests" => 4,
            "guests" => 1,
            "code" => null,
            "data" => json_encode([ "x" => "538.2857142857142","y" => "313.142857142857","width" => "130.28571428571433","height" => "129.71428571428578"] ),
            "handle" => json_encode([ "cx" => "668.5714285714286","cy" => "442.8571428571428","r" => "5"] )
          ] , [
            "id" => "14",
            "status" => "available",
            "max_guests" => 4,
            "guests" => 1,
            "code" => null,
            "data" => json_encode([ "x" => "375.71428571428567","y" => "464.2857142857142","width" => "142.85714285714283","height" => "142.85714285714283"] ),
            "handle" => json_encode([ "cx" => "518.5714285714284","cy" => "607.1428571428571","r" => "5"] )
          ] , [
            "id" => "15",
            "status" => "available",
            "max_guests" => 4,
            "guests" => 1,
            "code" => null,
            "data" => json_encode([ "x" => "532.8571428571428","y" => "467.14285714285705","width" => "142.85714285714283","height" => "142.85714285714283"] ),
            "handle" => json_encode([ "cx" => "675.7142857142856","cy" => "609.9999999999999","r" => "5"] )
          ] , [
            "id" => "16",
            "status" => "available",
            "max_guests" => 4,
            "guests" => 1,
            "code" => null,
            "data" => json_encode([ "x" => "380","y" => "622.8571428571429","width" => "142.85714285714283","height" => "142.85714285714283"] ),
            "handle" => json_encode([ "cx" => "522.8571428571429","cy" => "765.7142857142858","r" => "5"] )
          ] , [
            "id" => "17",
            "status" => "available",
            "max_guests" => 4,
            "guests" => 1,
            "code" => null,
            "data" => json_encode([ "x" => "532.8571428571429","y" => "622.8571428571428","width" => "142.85714285714283","height" => "142.85714285714283"] ),
            "handle" => json_encode([ "cx" => "675.7142857142858","cy" => "765.7142857142856","r" => "5"] )
          ] , [
            "id" => "18",
            "status" => "available",
            "max_guests" => 4,
            "guests" => 1,
            "code" => null,
            "data" => json_encode([ "x" => "847.142857142857","y" => "308.57142857142856","width" => "142.85714285714283","height" => "142.85714285714283"] ),
            "handle" => json_encode([ "cx" => "989.9999999999998","cy" => "451.4285714285714","r" => "5"] )
          ] , [
            "id" => "19",
            "status" => "available",
            "max_guests" => 4,
            "guests" => 1,
            "code" => null,
            "data" => json_encode([ "x" => "999.9999999999999","y" => "308.57142857142856","width" => "142.85714285714283","height" => "142.85714285714283"] ),
            "handle" => json_encode([ "cx" => "1142.8571428571427","cy" => "451.4285714285714","r" => "5"] )
          ] , [
            "id" => "20",
            "status" => "available",
            "max_guests" => 4,
            "guests" => 1,
            "code" => null,
            "data" => json_encode([ "x" => "850","y" => "467.1428571428571","width" => "142.85714285714283","height" => "142.85714285714283"] ),
            "handle" => json_encode([ "cx" => "992.8571428571429","cy" => "610","r" => "5"] )
          ] , [
            "id" => "21",
            "status" => "available",
            "max_guests" => 4,
            "guests" => 1,
            "code" => null,
            "data" => json_encode([ "x" => "1000","y" => "467.1428571428571","width" => "142.85714285714283","height" => "142.85714285714283"] ),
            "handle" => json_encode([ "cx" => "1142.857142857143","cy" => "610","r" => "5"] )
          ] , [
            "id" => "22",
            "status" => "available",
            "max_guests" => 4,
            "guests" => 1,
            "code" => null,
            "data" => json_encode([ "x" => "848.5714285714284","y" => "624.2857142857142","width" => "142.85714285714283","height" => "142.85714285714283"] ),
            "handle" => json_encode([ "cx" => "991.4285714285713","cy" => "767.1428571428571","r" => "5"] )
          ] , [
            "id" => "23",
            "status" => "available",
            "max_guests" => 4,
            "guests" => 1,
            "code" => null,
            "data" => json_encode([ "x" => "999.9999999999998","y" => "625.7142857142858","width" => "142.85714285714283","height" => "142.85714285714283"] ),
            "handle" => json_encode([ "cx" => "1142.8571428571427","cy" => "768.5714285714287","r" => "5"] )
          ] , 
        ]);
    }
}

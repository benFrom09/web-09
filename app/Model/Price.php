<?php
namespace App\Model;

use DateTime;
use App\Support\Model;

class Price extends Model
{

    public static function all() {
        $query = self::getDb()->prepare('SELECT p_id,p_title,p_price,p_devise,p_content,p_description,p_btn FROM Price');
        $query->execute([]);
        $data = $query->fetchAll();
        return $data;
    }

    public static function get($id) {
        $query = self::getDb()->prepare('SELECT p_id,p_title,p_price,p_devise,p_content,p_description,p_btn FROM Price WHERE p_id=?');
        $query->execute([$id]);
        $data = $query->fetch();
        return $data;
    }

    public static function update($request,$id) {
        $query = self::getDb()->prepare('UPDATE Price SET p_title = ?,p_price = ?,p_devise = ?,p_content = ?,p_description = ?,p_btn = ? WHERE p_id= ?');
        $data = $query->execute([
            $request['p_title'],
            $request['p_price'],
            $request['p_devise'],
            $request['p_content'],
            $request['p_description'],
            $request['p_btn'],
            $id
        ]);
        return $data;
    }

    public static function create($request) {
        $query = self::getDb()->prepare('INSERT INTO Price(p_title,p_price,p_devise,p_description,p_content,p_btn,created_at,updated_at) VALUES(?,?,?,?,?,?,?,?)');
        $data = $query->execute([
            $request['p_title'],
            (int) $request['p_price'],
            $request['p_devise'],
            $request['p_description'],
            $request['p_content'],
            $request['p_btn'],
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s')

        ]);
        return $data;
    }

    public static function delete($id) {
       $query = self::getDb()->prepare('DELETE FROM Price WHERE p_id = ?');
       $data = $query->execute([$id]);
       return $data;
    }
}
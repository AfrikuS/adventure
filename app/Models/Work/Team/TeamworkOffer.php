<?php

namespace App\Models\Work\Team;

use Illuminate\Database\Eloquent\Model;

class TeamworkOffer extends Model
{
    protected $table      = 'work_teamwork_offers';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable   = ['leader_user_id', 'users_count', 'kind_work'];

    public function leader() {
        return $this->belongsTo('App\Models\User', 'leader_user_id');
    }

    public function partners()
    {
        return $this->belongsToMany('App\Models\User', 
            'work_teamwork_offers_users_rels', 'teamwork_offer_id', 'partner_user_id');
    }

//        `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
//        `leader_user_id` INT UNSIGNED NOT NULL,
//        `users_count` INT UNSIGNED NOT NULL DEFAULT 0,
//        `kind_work` varchar(255) NOT NULL,
//        PRIMARY KEY(`id`),
//        FOREIGN KEY (leader_user_id) REFERENCES users(id)
//        );
//        
//        CREATE TABLE IF NOT EXISTS `work_teamwork_offers_users_rels` (
//        `teamwork_offer_id` INT UNSIGNED NOT NULL,
//        `partner_user_id` INT UNSIGNED NOT NULL,
//        FOREIGN KEY (teamwork_offer_id) REFERENCES work_teamwork_offers(id),
//        FOREIGN KEY (partner_user_id) REFERENCES users(id)
}

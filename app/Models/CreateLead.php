<?php

namespace App\Models;
use Predis\Client;
use Predis\Connection\ConnectionException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreateLead extends Model
{

    protected static function booted()
    {
        parent::booted();

        static::created(function ($createLead) {
            $redisKey = 'createleads:' . $createLead->id;

            try {
                $redis = new Client();
                $redis->hmset($redisKey, [
                    'lead_Name' => $createLead->lead_Name,
                    'email' => $createLead->email,
                    'fullName' => $createLead->fullName,
                    'Owner' => $createLead->Owner,
                    'phone' => $createLead->phone,
                    'mobile' => $createLead->mobile,
                    'lead_status' => $createLead->lead_status,
                    'companies_id' => $createLead->companies_id,
                    'user_id' => $createLead->user_id,
                    'role_id' => $createLead->role_id,
                    'uuid' => $createLead->uuid,
                ]);
            } catch (ConnectionException $exception) {
                // Handle connection exception if needed
            }
        });
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

     protected $fillable = [
        'p_id','lead_Name', 'company',  'email', 'lead_Source', 'fullName', 'fax','Owner','phone','mobile','lead_status','companies_id','user_id','role_id','uuid','website','industry','rating','noOfEmployees','annualRevenue','skypeID','secondaryEmail','twitter','city','street','pinCode','state','country','discription','title','related_activities'
        ];
    
    use HasFactory;
}

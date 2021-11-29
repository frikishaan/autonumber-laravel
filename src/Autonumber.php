<?php

namespace Frikishaan\Autonumber;

use Frikishaan\Autonumber\Models\Autonumber as AutonumberModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Autonumber
{
    /**
     * Static Function to generate autonumber
     * 
     * @param Model $model  
     */
    public static function generate(Model $model)
    {
        if(config('autonumber.use_locking'))
        {
            (new self)->generateAutonumberWithLock($model);
        }
        else
        {
            (new self)->generateAutonumber($model);
        }
    }

    /**
     * Function to generate Autonunmber without database locking
     * 
     * @param Model $model
     */
    public function generateAutonumber(Model $model) : void
    {
        $autonumbers = AutonumberModel::where('table_name', $model->getTable())->get();
        
        if(count($autonumbers) > 0){
            foreach ($autonumbers as $autonumber) {
                $model[$autonumber->column_name] = $autonumber->prefix . sprintf('%0'. $autonumber->min_digits .'d',$autonumber->next_number) . $autonumber->suffix;

                $autonumber->next_number +=1;
                $autonumber->update();
            }
        }
    }

    /**
     * Function to generate Autonumber with database lock
     * 
     * @param Model $model
     */
    public function generateAutonumberWithLock(Model $model) : void
    {
        DB::transaction(function () use ($model) {
            
            $autonumbers = AutonumberModel::lockForUpdate()->where('table_name', $model->getTable())->get();

            foreach ($autonumbers as $autonumber) {
                $model[$autonumber->column_name] = $autonumber->prefix . sprintf('%0'. $autonumber->min_digits .'d',
                $autonumber->next_number) . $autonumber->suffix;
                
                $autonumber->next_number +=1;
                $autonumber->update();
            }

        });        
    }
}
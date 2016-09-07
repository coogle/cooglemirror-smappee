<?php

namespace Cooglemirror\Smappee;

use Carbon\Carbon;
class Widget
{
    public function compose($view)
    {
        $usageRecords = UsageRecord::where('recorded_at', '>', Carbon::now()->setTimezone('UTC')->startOfDay())
                                   ->orderBy('recorded_at')
                                   ->get();
        
        $consumption = [];
        $alwaysOn = [];
        
        foreach($usageRecords as $record) {
            $consumption[] = [
                'label' => ' ',
                'y' => (double)$record->consumption + $record->always_on
            ];
        }
        
        foreach($usageRecords as $record) {
            $alwaysOn[] = [
                'label' => ' ',
                'y' => (double)$record->always_on
            ];
        }
        
        $view->with('smappeeAlwaysOn', $alwaysOn);
        $view->with('smappeeConsumption', $consumption);
    }
    
}
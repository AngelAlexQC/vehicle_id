<?php

namespace App\Observers;

use App\Events\RecordSaved;
use App\Models\Record;

class RecordObserver
{
    /**
     * Handle the Record "created" event.
     *
     * @param  \App\Models\Record  $record
     * @return void
     */
    public function created(Record $record)
    {
        RecordSaved::dispatch($record);
    }

    /**
     * Handle the Record "updated" event.
     *
     * @param  \App\Models\Record  $record
     * @return void
     */
    public function updated(Record $record)
    {
        //
    }

    /**
     * Handle the Record "deleted" event.
     *
     * @param  \App\Models\Record  $record
     * @return void
     */
    public function deleted(Record $record)
    {
        //
    }

    /**
     * Handle the Record "restored" event.
     *
     * @param  \App\Models\Record  $record
     * @return void
     */
    public function restored(Record $record)
    {
        //
    }

    /**
     * Handle the Record "force deleted" event.
     *
     * @param  \App\Models\Record  $record
     * @return void
     */
    public function forceDeleted(Record $record)
    {
        //
    }
}

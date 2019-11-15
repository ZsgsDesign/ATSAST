<?php

namespace App\Jobs;

use App\Models\Eloquents\Contest;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Exports\ContestRegistersExport;
use Storage;
use Excel;
use Str;

class ProcessContestRegistersExport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $contest;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Contest $contest)
    {
        $this->contest = $contest;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $filename = Str::random(40).'.xlsx';
        Excel::store(new ContestRegistersExport($this->contest), 'contest/xlsx/'.$filename, 'public');

        $this->contest->xlsx      = Storage::url('public/contest/xlsx/'.$filename);
        $this->contest->xlsx_time = date('Y-m-d H:i:s');

        $this->contest->save();
    }
}

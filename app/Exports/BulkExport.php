<?php


namespace App\Exports;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use App\Models\customerDetail;
use App\Models\DailyActivity;
use Maatwebsite\Excel\Concerns\FromCollection;


class BulkExport implements WithHeadings,FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $dat;
//($usract, $datepicker_from, $datepicker_to)
    public function __construct($usract, $datepicker_from, $datepicker_to)
    {
        $this->usract = $usract;
        $this->datepicker_from = $datepicker_from;
        $this->datepicker_to = $datepicker_to;
    }

    public function headings(): array
    {
        return [
            'Name',
            'Activity name',
            'Activity Date',
            'Activity Status',
            'Time Taken'
        ];
    }
    public function collection()
    {
        //dd($this->st);
        //WhereBetween('reservation_to', [$from2, $to2])
        return DailyActivity::join('users', 'daily_activities.usrId', '=', 'users.id')
        ->where('daily_activities.usrId', $this->usract)
        ->WhereBetween('actv_date', [$this->datepicker_from, $this->datepicker_to])
        ->get(['users.name', 'daily_activities.task', 'daily_activities.actv_date'
        , 'daily_activities.actv_stat', 'daily_activities.time_tkn']);

    }
    public function map($bulk): array
    {
        return [
            $bulk->name,
            $bulk->task,
            $bulk->actv_date,
            $bulk->actv_stat,
            $bulk->time_tkn,
            // Date::dateTimeToExcel($bulk->created_at),
            // Date::dateTimeToExcel($bulk->updated_at),
        ];
    }
}

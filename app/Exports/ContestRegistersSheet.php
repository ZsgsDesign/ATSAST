<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class ContestRegistersSheet implements FromCollection, WithEvents, WithStrictNullComparison, WithTitle
{
    private $title;
    private $only_audit;
    private $contest;
    private $registers;

    private $data;
    private $mergeCell = [];
    private $size = [1,1];

    public function __construct($contest,$only_audit,$title)
    {
        $this->title      = $title;
        $this->only_audit = $only_audit;
        $this->contest    = $contest;
        if($only_audit){
            $this->registers  = $contest->registers()->where('status',1)->get();
        }else{
            $this->registers  = $contest->registers;
        }
    }

    public function collection()
    {
        $this->header();
        if($this->contest->is_multiplayer){
            $row = 4;
            $index = 1;
            $team_index = 0;
            foreach ($this->registers as $register) {
                $team_index ++;
                $info = $register->info;
                $members = $info['members'];
                $this->data[$row][1] = '';
                $this->data[$row][2] = $team_index;
                $this->data[$row][3] = $register->team_name;
                $this->mergeCell     = array_merge($this->mergeCell,[
                    'B'.$row.':B'.($row+count($members)-1),
                    'C'.$row.':C'.($row+count($members)-1)
                ]);
                foreach ($members as $member) {
                    $this->data[$row][1] = $index;
                    if(empty($this->data[$row][2])){
                        $this->data[$row][2] = null;
                        $this->data[$row][3] = null;
                    }

                    $info_index = 1;
                    foreach ($this->contest->fields as $fields) {
                        $this->data[$row][3 + ($info_index ++)] = $member[$fields['name']];
                    }
                    $row ++;
                    $index ++;
                }
            }
        }else{
            $row = 3;
            foreach ($this->registers as $register) {
                $info = $register->info;
                $member = $info['members'][0];
                $info_index = 1;
                foreach ($this->contest->fields as $fields) {
                    $this->data[$row][1] = $row - 3;
                    $this->data[$row][3 + ($info_index ++)] = $member[$fields['name']];
                }
                $row ++;
            }
        }
        $this->size[1] = $row;
        return collect($this->data);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->setMergeCells($this->mergeCell);
                $event->sheet->getDelegate()->getStyle('A1:'.$this->getColumnIndex($this->size[0]).($this->size[1]-1))->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color'       => ['argb' => '000'],
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'wrapText'   => true,
                    ],
                    'font' => [
                        'name' => '等线'
                    ]
                ]);
                $event->sheet->getDelegate()->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                $event->sheet->getDelegate()->getStyle('A2')->getFont()->getColor()->setARGB('A6A6A6');
                $column_width = ['A' => 6, 'B' => 12, 'C' => 40];
                foreach (range('A',$this->getColumnIndex($this->size[0])) as $index) {
                    $event->sheet->getDelegate()->getColumnDimension($index)->setWidth($column_width[$index] ?? 18);
                }
                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(32);
                $event->sheet->getDelegate()->getRowDimension(2)->setRowHeight(20);
                foreach (range(3,$this->size[1] - 1) as $index){
                    $event->sheet->getDelegate()->getRowDimension($index)->setRowHeight(24);
                }
            },
        ];
    }

    private function header()
    {
        $this->data[0][] = $this->contest->name.' - 报名信息 '.$this->title;
        $this->data[1][] = '由 @SAST 生成';
        if($this->contest->is_multiplayer) {
            $this->data[2] = array_merge(['序号','队伍序号','队伍名称'],array_column($this->contest->fields,'placeholder'));
        }else{
            $this->data[2] = array_merge(['序号'],array_column($this->contest->fields,'placeholder'));
        }
        $this->mergeCell[] = $this->getColumnIndex(1).'1'.':'.$this->getColumnIndex(count($this->data[2])).'1';
        $this->mergeCell[] = $this->getColumnIndex(1).'2'.':'.$this->getColumnIndex(count($this->data[2])).'2';
        $this->size[0]     = count($this->data[2]);
    }

    private function getColumnIndex($index)
    {
        $chars = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ');
        if($index <= 26) {
            return $chars[$index - 1];
        }else{
            $index_1 = $index % 26;
            $index_2 = $index / 26;
            return $chars[$index_2 - 1].$chars[$index_1 - 1];
        }
    }

    public function title() : string
    {
        return $this->title;
    }
}

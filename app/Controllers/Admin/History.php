<?php

namespace App\Controllers\Admin;


class History extends BaseController
{

    public function __construct()
    {
        if (!in_groups(array('admin'))) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(lang('Auth.notEnoughPrivilege'));
        }
    }
    public function index()
    {
        return view($this->data['content'], $this->data);
    }

    public function table()
    {
        $History_model = model("HistoryModel");
        $limit = $this->request->getVar('length');
        $start = $this->request->getVar('start');
        $orders = $this->request->getVar('order');
        $page = ($start / $limit) + 1;
        $where = $History_model;
        $where->groupStart()
            ->where("factory_id !=", 4)
            ->orWhere("factory_id IS NULL")
            ->groupEnd();

        // Filter theo khoảng thời gian
        $date_from = $this->request->getPost('date_from');
        $date_to = $this->request->getPost('date_to');
        if (!empty($date_from)) {
            $where->where("created_at >=", $date_from . " 00:00:00");
        }
        if (!empty($date_to)) {
            $where->where("created_at <=", $date_to . " 23:59:59");
        }

        $totalData = $where->countAllResults(false);
        $totalFiltered = $totalData;
        if (empty($this->request->getPost('search')['value'])) {
            //            $max_page = ceil($totalFiltered / $limit);

        } else {
            $search = $this->request->getPost('search')['value'];
            $sWhere = "description like '%" . $search . "%'";
            $where = $where->where($sWhere);
            $totalFiltered = $where->countAllResults(false);
        }

        if (isset($orders)) {
            foreach ($orders as $order) {
                $data = $order['data'];
                $dir = $order['dir'];
                switch ($data) {
                    default:
                        $where->orderby($data, $dir);
                        break;
                    case 'status':
                        $where->orderby('status_id', $dir);
                        break;
                    case 'type':
                        $where->orderby('type_id', $dir);
                        break;
                }
            }
        }
        $posts = $where->asObject()->orderby("created_at", "DESC")->paginate($limit, '', $page);

        // $History_model->relation($posts, array('files', "status"));
        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $nestedData['created_at'] = $post->created_at;
                $nestedData['description'] = $post->description;
                $nestedData['name'] = $post->name;
                $nestedData['old_values'] = "<div style='word-break:break-all;'>$post->old_values</div>";
                $nestedData['new_values'] = "<div style='word-break:break-all;'>$post->new_values</div>";
                $nestedData['action'] = '';
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($this->request->getVar('draw')),
            "recordsTotal" => intval($totalFiltered),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }

    public function export()
    {
        ini_set('memory_limit', '512M');
        $History_model = model("HistoryModel");

        $where = $History_model;
        $where->groupStart()
            ->where("factory_id !=", 4)
            ->orWhere("factory_id IS NULL")
            ->groupEnd();

        // Filter theo khoảng thời gian
        $date_from = $this->request->getPost('date_from');
        $date_to = $this->request->getPost('date_to');
        if (!empty($date_from)) {
            $where->where("created_at >=", $date_from . " 00:00:00");
        }
        if (!empty($date_to)) {
            $where->where("created_at <=", $date_to . " 23:59:59");
        }

        // Search text
        $search = $this->request->getPost('search_text');
        if (!empty($search)) {
            $where->where("description like '%" . $search . "%'");
        }

        $posts = $where->asObject()->orderby("created_at", "DESC")->findAll();

        // Tạo spreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('AuditTrail');

        // Style cho header
        $headerStyle = [
            'font' => [
                'bold' => true,
                'name' => 'Times New Roman',
                'size' => 11,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4472C4'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        // Header
        $sheet->setCellValue('A1', 'STT');
        $sheet->setCellValue('B1', 'Ngày');
        $sheet->setCellValue('C1', 'User');
        $sheet->setCellValue('D1', 'Mô tả');
        $sheet->setCellValue('E1', 'Data cũ');
        $sheet->setCellValue('F1', 'Data mới');
        $sheet->getStyle('A1:F1')->applyFromArray($headerStyle);
        $sheet->getRowDimension(1)->setRowHeight(25);

        // Column widths
        $sheet->getColumnDimension('A')->setWidth(6);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(45);
        $sheet->getColumnDimension('E')->setWidth(50);
        $sheet->getColumnDimension('F')->setWidth(50);

        // Style cho data
        $dataStyle = [
            'font' => [
                'name' => 'Times New Roman',
                'size' => 10,
            ],
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        // Data rows
        $row = 2;
        $stt = 1;
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $sheet->setCellValue('A' . $row, $stt);
                $sheet->setCellValue('B' . $row, $post->created_at);
                $sheet->setCellValue('C' . $row, $post->name);
                $sheet->setCellValue('D' . $row, $post->description);
                $sheet->setCellValue('E' . $row, $post->old_values);
                $sheet->setCellValue('F' . $row, $post->new_values);
                $sheet->getRowDimension($row)->setRowHeight(-1);
                $row++;
                $stt++;
            }
        }

        // Apply style cho data
        if ($row > 2) {
            $sheet->getStyle('A2:F' . ($row - 1))->applyFromArray($dataStyle);
            // Căn giữa cột STT
            $sheet->getStyle('A2:A' . ($row - 1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        }

        // Lưu file
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $name = 'audit_trail_' . date('Ymd_His') . '.xlsx';
        $file = "assets/excel/$name";

        // Tạo thư mục nếu chưa có
        if (!is_dir('assets/excel')) {
            mkdir('assets/excel', 0777, true);
        }

        $writer->save($file);
        echo json_encode(base_url($file));
    }
}

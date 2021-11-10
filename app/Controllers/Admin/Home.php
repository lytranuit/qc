<?php

namespace App\Controllers\Admin;


class Home extends BaseController
{
    public function index()
    {
        return view($this->data['content'], $this->data);
    }
    public function listqrcode()
    {

        $Document_model = model("DocumentModel");
        $documents = $Document_model->findAll();

        // Creating the new document...
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        /* Note: any element you append to a document must reside inside of a Section. */

        // Adding an empty Section to the document...
        $section = $phpWord->addSection();

        $styleCell =
            [
                'borderColor' => 'ffffff',
                'borderSize' => 6,
            ];
        $table = $section->addTable(array('borderSize' => 0, 'cellMargin'  => 80, 'width' => 100 * 50, 'unit' => \PhpOffice\PhpWord\Style\Table::WIDTH_PERCENT, 'valign' => 'center'));

        $count = 0;
        foreach ($documents as $row) {
            $count++;
            if ($count > 6)
                $count = 1;
            if ($count == 1)
                $table->addRow(null, []);
            $cell = $table->addCell(null, $styleCell);
            $cell->addImage(
                APPPATH . '..' . $row->image_url,
                array(
                    'align' => 'center',
                    'width'         => 70,
                    'height'        => 70,
                    'marginTop'     => -1,
                    'marginLeft'    => -1,
                    'wrappingStyle' => 'behind'
                )
            );
            $name = basename($row->image_url);
            $cell->addText($name, array('size' => 8), array('align' => 'center'));
        }

        // Saving the document as OOXML file...
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save(time() . '.docx');
    }
}

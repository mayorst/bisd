<?php if (!defined('BASEPATH'))
{
    exit('No direct script access allowed');}

class Public_Variables
{

    const CREATE = 'create';
    const UPDATE = 'update';

    const GENDER = array('male' => 'M', 'female' => 'F');
    const ACCOUNT_POSITION = array('member' => 'Member', 'admin' => 'Admin');
    const ACCOUNT_STATUS = array('active' => 'Active', 'blocked' => 'Blocked');

    const EXTERNAL_LINKS_JSON = FILES_PATH.'site_external_link.json';

// ================  UI Variables ============================

    const UI_TABLE_TEMPLATE = array(
        'table_open' => '<table class="table table-hover">',

        'thead_open' => '<thead>',
        'thead_close' => '</thead>',

        'heading_row_start' => '<tr>',
        'heading_row_end' => '</tr>',
        'heading_cell_start' => '<th scope="col">',
        'heading_cell_end' => '</th>',

        'tbody_open' => '<tbody>',
        'tbody_close' => '</tbody>',

        'row_start' => '<tr>',
        'row_end' => '</tr>',
        'cell_start' => '<td scope="row">',
        'cell_end' => '</td>',

        'row_alt_start' => '<tr class="table-secondary">',
        'row_alt_end' => '</tr>',
        'cell_alt_start' => '<td>',
        'cell_alt_end' => '</td>',

        'table_close' => '</table>',
    );

// ============= PDF Reports ============

    public static function get_pdf_header()
    {
        require APPPATH . '/config/custom/config1.php';

        $logo = get_local_dir($config['path_logo']);
        $prrm = get_local_dir($config['path_prrm_logo']);

        $logo = get_data_URI($logo,'png');
        $prrm = get_data_URI($prrm,'png');
        
        $header =
            '
        <table style="width:100%; line-height: 1px;">
            <tbody>
                <tr>
                    <td style="width:15%; text-align: center;">
                        <img alt="logo" src="' . $logo . '" style="display: inline-block; width: 100px; height: auto;">
                    </td><td style="width:70%; text-align: center;">
                        <h5>Philippine Rural Reconstruction Movement</h5>
                        <h5>Benitez Institute for Sustainable Development</h5>
                    </td><td style="width:15%; text-align: center;">
                        <img alt="logo" src="' . $prrm . '" style="display: inline-block; width: 100px; height: auto;">
                    </td>
                </tr>
            </tbody>
        </table>
        ';
        return $header;
    }

    const UI_TABLE_PDF_REPORTS_TEMPLATE = array(
        'table_open' => '<table  style="width:100%; font-size: 10pt;">',

        'thead_open' => '<thead style="color:white; background-color: #4C4C4CFF; font-size: 12pt;">',
        'thead_close' => '</thead>',

        'heading_row_start' => '<tr>',
        'heading_row_end' => '</tr>',
        'heading_cell_start' => '<th scope="col">',
        'heading_cell_end' => '</th>',

        'tbody_open' => '<tbody>',
        'tbody_close' => '</tbody>',

        'row_start' => '<tr>',
        'row_end' => '</tr>',
        'cell_start' => '<td scope="row">',
        'cell_end' => '</td>',

        'row_alt_start' => '<tr style="background-color:#E0E0E0FF;">',
        'row_alt_end' => '</tr>',
        'cell_alt_start' => '<td>',
        'cell_alt_end' => '</td>',

        'table_close' => '</table>',
    );

}

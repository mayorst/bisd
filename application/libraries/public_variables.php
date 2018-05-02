<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class Public_Variables
{

    const CREATE = 'create';
    const UPDATE = 'update';

    const GENDER = array('male' => 'M', 'female' => 'F');
    const ACCOUNT_POSITION = array('member' => 'Member', 'admin' => 'Admin');
    const ACCOUNT_STATUS = array('active' => 'Active', 'blocked' => 'Blocked');

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

}

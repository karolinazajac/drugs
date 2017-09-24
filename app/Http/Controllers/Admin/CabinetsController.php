<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Cabinet;

class CabinetsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Cabinet
            ::select('cabinets.*')
            ->leftJoin('users', 'cabinets.user_id', '=','users.id')
            ->select('cabinets.*','users.email');

        $grid = new Grid(
            (new GridConfig)
                # Grids name used as html id, caching key, filtering GET params prefix, etc
                # If not specified, unique value based on file name & line of code will be generated
                ->setName('cabinets')
                # See all supported data providers in sources
                ->setDataProvider(new EloquentDataProvider($query))
                # Setup table columns
                ->setColumns([
                    # simple results numbering, not related to table PK or any obtained data
                    new IdFieldConfig(),
                    (new FieldConfig)
                        ->setName('cabinet_name')
                        # will be displayed in table header
                        ->setLabel('Nazwa')
                        # That's all what you need for filtering.
                        # It will create controls, process input
                        # and filter results (in case of EloquentDataProvider -- modify SQL query)
                        ->addFilter(
                            (new FilterConfig)
                                ->setName('cabinet_name')
                                ->setOperator(FilterConfig::OPERATOR_LIKE)
                        )

                        # sorting buttons will be added to header, DB query will be modified
                        ->setSortable(true)
                    ,
                    (new FieldConfig)
                        ->setName('users_email')
                        # will be displayed in table header
                        ->setLabel('Email')
                    ,
                    (new FieldConfig)
                        ->setName('created_at')
                        ->setLabel('Konto utworzone')
                        ->setSortable(true),
                    (new FieldConfig)
                        ->setName('updated_at')
                        ->setLabel('Ostatnia aktywność')
                        ->setSortable(true),


                ])
                # Setup additional grid components
                ->setComponents([
                    # Renders table header (table>thead)
                    (new THead)
                        # Setup inherited components
                        ->setComponents([
                            # Add this if you have filters for automatic placing to this row
                            (new FiltersRow),
                            # Row with additional controls
                            (new OneCellRow)
                                ->setComponents([
                                    # Control for specifying quantity of records displayed on page
                                    (new RecordsPerPage)
                                        ->setVariants([
                                            5,
                                            10,
                                            20
                                        ])
                                    ,
                                    # CSV EXPORT function
                                    (new CsvExport)
                                        ->setFileName('my_report' . date('Y-m-d'))
                                    ,
                                    # Control to show/hide rows in table
                                    (new ColumnsHider)
                                        ->setHiddenByDefault([
                                            'is_hidden',
                                        ])
                                    ,
                                    # Submit button for filters.
                                    # Place it anywhere in the grid (grid is rendered inside form by default).
                                    (new HtmlTag)
                                        ->setTagName('button')
                                        ->setAttributes([
                                            'type' => 'submit',
                                            # Some bootstrap classes
                                            'class' => 'btn btn-primary'
                                        ])
                                        ->setContent('Filter')
                                ])
                                # Components may have some placeholders for rendering children there.
                                ->setRenderSection(THead::SECTION_BEGIN),
                            (new ColumnHeadersRow)

                        ])
                    ,
                    # Renders table footer (table>tfoot)
                    (new TFoot)
                        ->setComponents([
                            (new OneCellRow)
                                ->setComponents([
                                    new Pager,
                                    (new HtmlTag)
                                        ->setAttributes(['class' => 'pull-right'])
                                    ,
                                ])
                        ])
                    ,
                ])
        );
        return view('admin.cabinets', compact('grid'));
    }
}

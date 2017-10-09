<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\DB;
use Nayjest\Grids\GridConfig;
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\IdFieldConfig;
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\FilterConfig;
use Nayjest\Grids\Components\THead;
use Nayjest\Grids\Components\FiltersRow;
use Nayjest\Grids\Components\OneCellRow;
use Nayjest\Grids\Components\RecordsPerPage;
use Nayjest\Grids\Components\ColumnsHider;
use Nayjest\Grids\Components\HtmlTag;
use Nayjest\Grids\Components\TFoot;
use Nayjest\Grids\Components\Laravel5\Pager;
use Nayjest\Grids\Grid;
use Nayjest\Grids\Components\CsvExport;
use Nayjest\Grids\Components\ColumnHeadersRow;
use Nayjest\Grids\Components\RenderFunc;
use Nayjest\Grids\Components\Filters\DateRangePicker;
use Collective\Html\HtmlFacade;
use Carbon\Carbon;
use Nayjest\Grids\DataProvider;

class UsersController extends Controller
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
     * Show the users dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get all users data
        //wybierz wszystkich użytkowników
        $query = User
            ::select('users.*');
        //build grid with users data
        //zbuduj tabelę z użytkownikami
        $grid = new Grid(
            (new GridConfig)
                # Grids name used as html id, caching key, filtering GET params prefix, etc
                # If not specified, unique value based on file name & line of code will be generated
                ->setName('drugs')
                # See all supported data providers in sources
                ->setDataProvider(new EloquentDataProvider($query))
                # Setup table columns
                ->setColumns([
                    # simple results numbering, not related to table PK or any obtained data
                    new IdFieldConfig(),
                    (new FieldConfig)
                        ->setName('name')
                        # will be displayed in table header
                        ->setLabel('Nazwa')
                        # That's all what you need for filtering.
                        # It will create controls, process input
                        # and filter results (in case of EloquentDataProvider -- modify SQL query)
                        ->addFilter(
                            (new FilterConfig)
                                ->setName('name')
                                ->setOperator(FilterConfig::OPERATOR_LIKE)
                        )

                        # sorting buttons will be added to header, DB query will be modified
                        ->setSortable(true)
                    ,
                    (new FieldConfig)
                        ->setName('email')
                        # will be displayed in table header
                        ->setLabel('Email')
                        # That's all what you need for filtering.
                        # It will create controls, process input
                        # and filter results (in case of EloquentDataProvider -- modify SQL query)
                        ->addFilter(
                            (new FilterConfig)
                                ->setName('email')
                                ->setOperator(FilterConfig::OPERATOR_LIKE)
                        )

                        # sorting buttons will be added to header, DB query will be modified
                        ->setSortable(true)
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
        return view('admin.users', compact('grid'));
    }
}

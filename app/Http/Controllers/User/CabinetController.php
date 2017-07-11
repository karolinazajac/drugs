<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\CabinetDrug;
use App\Drug;
use App\Cabinet;
use App\User;
use Auth;
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

class CabinetController extends Controller
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
//        $cabinet=Cabinet::find($val);
//        $name=$cabinet->name;
//        $id=$cabinet->id;
//        $query = CabinetDrug
//            ::where('cabinet_id', $id)
//            ->select('cabinet_drugs.*')
//        ::leftJoin('drugs', 'cabinet_drugs.ean', '=','drugs.ean')
//            ->select('cabinet_drugs.*','countries.name')
//            ->newQuery()
//            ->where('movie_id', $val);
//
//        $grid = new Grid(
//            (new GridConfig)
//                # Grids name used as html id, caching key, filtering GET params prefix, etc
//                # If not specified, unique value based on file name & line of code will be generated
//                ->setName('movies')
//                # See all supported data providers in sources
//                ->setDataProvider(new EloquentDataProvider($query))
//                # Setup table columns
//                ->setColumns([
//                    # simple results numbering, not related to table PK or any obtained data
//                    new IdFieldConfig(),
//                    (new FieldConfig('email'))
//                        ->setName('email')
//                        # will be displayed in table header
//                        ->setLabel('User')
//                        # sorting buttons will be added to header, DB query will be modified
//                        ->setSortable(true)
//                    ,
//                    (new FieldConfig('country_id'))
//                        ->setName('name')
//                        # will be displayed in table header
//                        ->setLabel('Country')
//                        # That's all what you need for filtering.
//                        # It will create controls, process input
//                        # and filter results (in case of EloquentDataProvider -- modify SQL query)
//                        ->addFilter(
//                            (new FilterConfig)
//                                ->setName('countries.name')
//                                ->setOperator(FilterConfig::OPERATOR_LIKE)
//                        )
//
//                        # sorting buttons will be added to header, DB query will be modified
//                        ->setSortable(true)
//                    ,
//                    (new FieldConfig('gender'))
//                        ->setName('gender')
//                        # will be displayed in table header
//                        ->setLabel('Gender')
//                        # That's all what you need for filtering.
//                        # It will create controls, process input
//                        # and filter results (in case of EloquentDataProvider -- modify SQL query)
//                        ->addFilter(
//                            (new FilterConfig)
//                                ->setName('users.gender')
//                                ->setOperator(FilterConfig::OPERATOR_LIKE)
//                        )
//
//                        # sorting buttons will be added to header, DB query will be modified
//                        ->setSortable(true)
//                    ,
//                    (new FieldConfig)
//                        ->setName('created_at')
//                        ->setLabel('Date')
//                        ->setSortable(true)
//                        ->setCallback(function ($val) {
//                            return $val->toDateString();
//                        }),
//                ])
//                # Setup additional grid components
//                ->setComponents([
//                    # Renders table header (table>thead)
//                    (new THead)
//                        # Setup inherited components
//                        ->setComponents([
//                            # Add this if you have filters for automatic placing to this row
//                            (new FiltersRow)
//                                ->addComponents([
//                                    (new RenderFunc(function () {
//                                        return HtmlFacade::style('css/daterangepicker.css')
//                                            . HtmlFacade::script('js/jquery-3.2.1.min.js')
//                                            . HtmlFacade::script('js/moment-with-locales.min.js')
//                                            . HtmlFacade::script('js/datarangepicker-stats.js')
//                                            . HtmlFacade::script('js/bootstrap-datepicker.js')
//                                            . "<style>
//                                                .daterangepicker td.available.active,
//                                                .daterangepicker li.active,
//                                                .daterangepicker li:hover {
//                                                    color:black !important;
//                                                    font-weight: bold;
//                                                }
//                                           </style>";
//                                    }))
//                                        ->setRenderSection('filters_row_column_created_at'),
//                                    (new DateRangePicker)
//                                        ->setName('created_at')
//                                        ->setRenderSection('filters_row_column_created_at')
//                                        ->setDefaultValue([Carbon::now()->subDays(7)->format('y-m-d'), Carbon::now()->format('y-m-d')])
//                                        ->setFilteringFunc(function ($value, DataProvider $provider) {
//                                            $start=new Carbon($value[0]);
//                                            $end=new Carbon($value[1]);
//                                            $provider->filter('video_events.created_at', '>=', $start->toDateTimeString());
//                                            $provider->filter('video_events.created_at', '<=', $end->addSeconds(86399)->toDateTimeString());
//                                        })
//                                ])
//                            ,
//                            # Row with additional controls
//                            (new OneCellRow)
//                                ->setComponents([
//                                    # Control for specifying quantity of records displayed on page
//                                    (new RecordsPerPage)
//                                        ->setVariants([
//                                            5,
//                                            10,
//                                            20
//                                        ])
//                                    ,
//                                    # CSV EXPORT function
//                                    (new CsvExport)
//                                        ->setFileName('my_report' . date('Y-m-d'))
//                                    ,
//                                    # Control to show/hide rows in table
//                                    (new ColumnsHider)
////                                        ->setHiddenByDefault([
////                                            'is_hidden',
////                                        ])
//                                    ,
//                                    # Submit button for filters.
//                                    # Place it anywhere in the grid (grid is rendered inside form by default).
//                                    (new HtmlTag)
//                                        ->setTagName('button')
//                                        ->setAttributes([
//                                            'type' => 'submit',
//                                            # Some bootstrap classes
//                                            'class' => 'btn btn-primary'
//                                        ])
//                                        ->setContent('Filter')
//                                ])
//                                # Components may have some placeholders for rendering children there.
//                                ->setRenderSection(THead::SECTION_BEGIN),
//                            (new ColumnHeadersRow)
//
//                        ])
//                    ,
//                    # Renders table footer (table>tfoot)
//                    (new TFoot)
//                        ->setComponents([
//                            (new OneCellRow)
//                                ->setComponents([
//                                    new Pager,
//                                    (new HtmlTag)
//                                        ->setAttributes(['class' => 'pull-right'])
//                                    ,
//                                ])
//                        ])
//                    ,
//                ])
//        );

//        return view('user.cabinet', compact('grid','name'));
        return view('user.cabinet');
    }

    public function getDrugs()
    {
        $data = array();
        $results = DB::table('drugs')->get();


        foreach ( $results as $result ):
            $data[] = [ 'id' => $result->ean, 'name' => $result->name, 'package'=>$result->package ];
        endforeach;

//        var_dump($data);
        return \Response::json($data);
    }

    public function createCabinet(Request $request)
    {
        $cabinet = new Cabinet;
        $cabinet->cabinet_name = $request->cabinet_name;
        $cabinet->user_id = Auth::user()->id;;
        $cabinet->save();
        Auth::user()->cabinets()->attach($cabinet->id);
        foreach (Input::get('user_email') as $key => $val) {
            $newUser=User::where('email',$key) -> first();
            $newUser->cabinets()->attach($cabinet->id);
        }
        return back();
    }
}

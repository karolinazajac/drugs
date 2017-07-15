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
        $cabinetsList=Auth::user()->cabinets();
        $mainCabinet=Auth::user()->cabinets()->where('main', true)->first();

        $id=$mainCabinet->id;
        $query = CabinetDrug
            ::where('cabinet_id', $id)
            ->select('cabinet_drugs.*')
        ->leftJoin('drugs', 'cabinet_drugs.ean', '=','drugs.ean')
            ->select('cabinet_drugs.*','drugs.name');
        $cabinetDrugs = CabinetDrug
            ::where('cabinet_id', $id)
            ->select('cabinet_drugs.*')
            ->leftJoin('drugs', 'cabinet_drugs.ean', '=','drugs.ean')
            ->select('cabinet_drugs.*','drugs.name')->get();
//        $grid = new Grid(
//            (new GridConfig)
//                # Grids name used as html id, caching key, filtering GET params prefix, etc
//                # If not specified, unique value based on file name & line of code will be generated
//                ->setName('cabinetDrugs')
//                # See all supported data providers in sources
//                ->setDataProvider(new EloquentDataProvider($query))
//                # Setup table columns
//                ->setColumns([
//                    # simple results numbering, not related to table PK or any obtained data
//                    new IdFieldConfig(),
//                    (new FieldConfig('drugs.name'))
//                        ->setName('name')
//                        # will be displayed in table header
//                        ->setLabel('Nazwa leku')
//                        ->addFilter(
//                            (new FilterConfig)
//                                ->setName('drugs.name')
//                                ->setOperator(FilterConfig::OPERATOR_LIKE)
//                        )
//                        # sorting buttons will be added to header, DB query will be modified
//                        ->setSortable(true)
//                    ,
//                    (new FieldConfig('quantity'))
//                        ->setName('quantity')
//                        # will be displayed in table header
//                        ->setLabel('Ilość')
//                        # sorting buttons will be added to header, DB query will be modified
//                        ->setSortable(true)
//                    ,
//                    (new FieldConfig('expiration_date'))
//                        ->setName('expiration_date')
//                        # will be displayed in table header
//                        ->setLabel('Data ważności')
//                        # sorting buttons will be added to header, DB query will be modified
//                        ->setSortable(true)
//                    ,
//                    (new FieldConfig)
//                        ->setName('price')
//                        ->setLabel('Cena')
//                        ->setSortable(true)
//
//                ])
//                # Setup additional grid components
//                ->setComponents([
//                    # Renders table header (table>thead)
//                    (new THead)
//                        # Setup inherited components
//                        ->setComponents([
//                            # Add this if you have filters for automatic placing to this row
//                            (new FiltersRow)
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
        return view('user.cabinet', compact( 'cabinetsList', 'mainCabinet', 'cabinetDrugs'));
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
        if(!is_null(Input::get('user_email'))){
            foreach (Input::get('user_email') as $key => $val) {
                $newUser=User::where('email',$key) -> first();
                $newUser->cabinets()->attach($cabinet->id);
            }
        }
        return back();
    }

    public function addDrug (Request $request)
    {
        $cabinetDrug = new CabinetDrug;
        $cabinetDrug->ean = $request->ean;
        $cabinetDrug->cabinet_id = $request->cabinetId;
        $cabinetDrug->quantity = $request->quantity;
        $cabinetDrug->expiration_date = Carbon::createFromFormat('d/m/Y', $request->date);
        $cabinetDrug->price = $request->price;
        $cabinetDrug->current_state = 1;
        $cabinetDrug->save();

        return back();
    }

    public function deleteDrug ($id)
    {
        $cabinetDrug = CabinetDrug::findOrFail($id);

        $cabinetDrug->delete();

        return back();
    }

    public function editDrug (Request $request, $id)
    {
        $cabinetDrug = CabinetDrug::findOrFail($id);
        $cabinetDrug->quantity = $request->input('updatedQuantity');
        $cabinetDrug->save();
        return back();
    }
}

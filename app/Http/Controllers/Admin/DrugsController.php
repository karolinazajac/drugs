<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Drug;
use Excel;
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

class DrugsController extends Controller
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
        $query = Drug
            ::select('drugs.*');

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
                        ->setName('ean')
                        # will be displayed in table header
                        ->setLabel('Nr. EAN')
                        # That's all what you need for filtering.
                        # It will create controls, process input
                        # and filter results (in case of EloquentDataProvider -- modify SQL query)
                        ->addFilter(
                            (new FilterConfig)
                                ->setName('ean')
                                ->setOperator(FilterConfig::OPERATOR_LIKE)
                        )

                        # sorting buttons will be added to header, DB query will be modified
                        ->setSortable(true)
                    ,
                    (new FieldConfig)
                        ->setName('basyl')
                        # will be displayed in table header
                        ->setLabel('Nr. Basyl')
                        # That's all what you need for filtering.
                        # It will create controls, process input
                        # and filter results (in case of EloquentDataProvider -- modify SQL query)
                        ->addFilter(
                            (new FilterConfig)
                                ->setName('basyl')
                                ->setOperator(FilterConfig::OPERATOR_LIKE)
                        )

                        # sorting buttons will be added to header, DB query will be modified
                        ->setSortable(true)
                    ,
                    (new FieldConfig)
                        ->setName('name')
                        # will be displayed in table header
                        ->setLabel('Nazwa handlowa')
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
                        ->setName('manufacturer')
                        ->setLabel('Producent')
                        ->setSortable(true),
                    (new FieldConfig)
                        ->setName('package')
                        ->setLabel('Opakowanie')
                        ->setSortable(true),
                    (new FieldConfig)
                        ->setName('dose')
                        ->setLabel('Dawka')
                        ->setSortable(true),
                    (new FieldConfig)
                        ->setName('character')
                        ->setLabel('Postać')
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
        return view('admin.drugs', compact('grid'));
    }

    /**
     * Import file into database Code
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function importExcel(Request $request)
    {

        if($request->hasFile('import_file')){
            $path = $request->file('import_file')->getRealPath();

            $data = Excel::load($path, function($reader) {})->get();

            if(!empty($data) && $data->count()){

                foreach ($data->toArray() as $key => $value) {
                    if(!empty($value)){
                        foreach ($value as $v) {
                            $insert[] = ['ean' => $v['ean'], 'name' => $v['name'], 'manufacturer' => $v['manufacturer'], 'package' => $v['package'], 'dose' => $v['dose'], 'character' => $v['character'], 'basyl' => $v['basyl']];
                        }
                    }
                }


                if(!empty($insert)){
                    Drug::insert($insert);
                    return back()->with('success','Rekordy zostały pomyślnie dodane do tabeli :)');
                }

            }

        }

        return back()->with('error','Sprawdź importowany plik, coś jest z nim nie tak :(');
    }
}

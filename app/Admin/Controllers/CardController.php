<?php

namespace App\Admin\Controllers;

use App\Models\Card;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Illuminate\Support\MessageBag;

class CardController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('卡密')
            ->description('列表')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('卡密')
            ->description('详情')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('卡密')
            ->description('编辑')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('卡密')
            ->description('创建')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Card);
        $grid->actions(function ($actions) {
            //$actions->disableDelete();
            $actions->disableEdit();
            $actions->disableView();
        });
        $grid->id('ID');
        $grid->goods()->name('所属商品');
        $grid->content('卡密');
        $grid->status('状态')->display(function ($status) {
            switch ($status){
                case 0:
                    return '<span class="label label-primary">正常</span>';
                case 1:
                    return '<span class="label label-info">已售出</span>';
            }
        });;
        $grid->created_at('创建时间');

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Card::findOrFail($id));

        $show->id('ID');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Card);
        $categoryOptions = [];
        $categories = Category::all();
        foreach ($categories as $key => $category) {
            $categoryOptions[$category->id] = $category->name;
        }
        $form->select('category_id', '商品分类')
            ->options($categoryOptions)
            ->load('goods_id', '/api/card_goods');
        $form->select('goods_id', '商品')->rules('required', [
            'required' => '请选择商品',
        ]);
        $form->textarea('cards', '卡密列表')->help('格式：卡号----卡密 或者卡号 一行一条')
            ->rules('required', [
                'required' => '请输入卡密',
            ]);
        $form->select('filter', '过滤重复卡密')->options(['不过滤','过滤']);
        return $form;
    }

    public function store()
    {
        $data = Input::all();
        // Handle validation errors.
        if ($validationMessages = $this->form()->validationMessages($data)) {
            return back()->withInput()->withErrors($validationMessages);
        }
        $goodsId = $data['goods_id'];
        $cards = explode("\r\n", $data['cards']);
        $datas = [];
        $contentDatas = [];
        foreach ($cards as $key => $card) {
            if(in_array($card,$contentDatas) && $data['filter']){
                continue;
            }
            $contentDatas[] = $card;
            $datas[$key]['content'] = $card;
            $datas[$key]['goods_id'] = $goodsId;
            $datas[$key]['created_at'] = Carbon::now();
        }
        if($data['filter']){
            $existsCards = Card::whereIn('content',$cards)->get();
            if(!$existsCards->isEmpty()){
                $existsCardsContent = $existsCards->pluck('content')->toArray();
                $existsString = implode(',',$existsCardsContent);
                $error = new MessageBag([
                    'message' => "卡密重复({$existsString})",
                ]);
                return back()->with(compact('error'));
            }
        }
        Card::insert($datas);
        admin_toastr(trans('admin.save_succeeded'));
        $resourcesPath = $this->form()->resource(-1);
        return redirect($resourcesPath.'/cards');
    }

}

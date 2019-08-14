<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use App\Models\EmailTemplate;
use App\Models\Goods;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class GoodsController extends Controller
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
            ->header('商品')
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
            ->header('商品')
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
            ->header('商品')
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
            ->header('商品')
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
        $grid = new Grid(new Goods);
        $grid->model()->orderBy('sort','asc');
        $grid->id('ID');
        $grid->sort('排序');
        $grid->category()->name('分类名称');
        $grid->name('商品名称');
        $grid->price('商品价格');
        $grid->type('商品类型')->display(function ($type) {
            switch ($this->type){
                case 1:
                    return '<span class="label label-primary">手动发卡</span>';
                case 2:
                    return '<span class="label label-success">自动发卡</span>';
            }
        });
        $grid->sold_count('商品销量');
        $grid->column('goods_stock','商品库存')->display(function ($goodsStock) {
            return $this->goodsStock();
        });
        $grid->status('上架状态')->display(function ($status) {
            return $status ? '<span class="label label-success">是</span>' : '<span class="label label-danger">否</span>';
        });
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');

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
        $show = new Show(Goods::findOrFail($id));

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
        $form = new Form(new Goods);
        $categories = Category::all();
        $categoryOptions = [];
        foreach($categories as $key=>$category){
            $categoryOptions[$category->id] = $category->name;
        }
        $form->text('sort','排序')->default(0)->rules('required|numeric',[
            'required' => '请输入排序',
            'numeric'   => '排序只能为数字',
        ]);
        $form->select('category_id', '所属分类')->options($categoryOptions)->rules('required',[
            'required' => '请选择分类',
        ]);
        $form->text('name','商品名称')->rules('required',[
            'required' => '请输入商品名称',
        ]);
        $form->currency('price','商品价格')->symbol('￥')->options(['digits' => 2]);
        $form->editor('introduce','商品介绍');
        $form->text('first_input','第一个输入框标题')->help('如商品是自动发卡请勿填写!');
        $form->text('more_input','更多输入框')->help('例如 密码,大区 以英文逗号分割;如商品是自动发卡请勿填写!');
        $form->number('stock','商品库存')->default(0)->help('如商品是自动发卡请勿填写，导入卡密时会自动识别');
        $form->select('type','商品类型')->options([1=>'手工商品',2=>'自动发卡'])->default(1);
        $form->select('status', '是否上架')->options(['下架','上架'])->default(1);
        $emailTemplateOptions = [];
        $emailTemplates = EmailTemplate::all();
        foreach($emailTemplates as $emailTemplate){
            $emailTemplateOptions[$emailTemplate->id] = $emailTemplate['name'];
        }
        $form->select('email_template_id', '邮件模板')->options($emailTemplateOptions)->default(1);
        $form->display('Created at');
        $form->display('Updated at');

        return $form;
    }

}

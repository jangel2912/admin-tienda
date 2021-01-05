<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\Category\CreateRequest;
use App\Models\Shop\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $search =  $request->input('search_text');

        if ($search && $search !== '') {
            $categories = Category::where([
                ['nombre', 'like', '%' . $search . '%'],
                'padre' => null,
            ])
            ->orderBy('nombre')
            ->paginate(5);
        } else {
            $categories = Category::where('padre', null)->orderBy('nombre')->paginate(5);
        }

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {
        $subcategories = $request->input('subcategories');
        $sub_subcategories = $request->input('sub_subcategories');
        $category = new Category;
        $category->codigo = $request->code;
        $category->nombre = $request->name;
        $category->padre = $request->father;

        if ($category->save()) {
            if (is_array($subcategories)) {
                foreach ($subcategories as $key => $value) {
                    if (!is_null($value)) {
                        $subcategory = new Category;
                        $subcategory->nombre = $value;
                        $subcategory->padre = $category->id;

                        if ($subcategory->save() && is_array($sub_subcategories) && array_key_exists($key, $sub_subcategories) && !is_null($sub_subcategories[$key])) {
                            foreach (explode(',', $sub_subcategories[$key]) as $value) {
                                if (!is_null($value)) {
                                    $sub_subcategory = new Category;
                                    $sub_subcategory->nombre = $value;
                                    $sub_subcategory->padre = $subcategory->id;
                                    $sub_subcategory->save();
                                }
                            }
                        }
                    }
                }
            }

            return redirect()->route('admin.categories.index')->with('success', "La categoría {$category->nombre} se ha creado con éxito.");
        }

        return back()->with('danger', 'Ha ocurrido un error.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $category = Category::with(['subcategories'])->where([
            'id' => $id,
            'padre' => null,
        ])->first();

        if (!is_null($category)) {
            return view('admin.categories.edit', compact('category'));
        }

        return redirect()->route('admin.categories.index')->with('danger', 'Ha ocurrido un error.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if (!is_null($category)) {
            $subcategories = $request->input('subcategories');
            $sub_subcategories = $request->input('sub_subcategories');
            $category->codigo = $request->code;
            $category->nombre = $request->name;

            if ($category->save()) {
                foreach ($category->subcategories as $key => $subcategory) {
                    if (is_array($subcategories) && array_key_exists($key, $subcategories) && !is_null($subcategories[$key])) {
                        $subcategory->nombre = $subcategories[$key];

                        if ($subcategory->save()) {
                            $subcategory_sub_subcategories = [];

                            if (is_array($sub_subcategories) && array_key_exists($key, $sub_subcategories) && !is_null($sub_subcategories[$key])) {
                                $subcategory_sub_subcategories = explode(',', $sub_subcategories[$key]);
                            }

                            foreach ($subcategory->subcategories as $key => $sub_subcategory) {
                                if (array_key_exists($key, $subcategory_sub_subcategories) && !is_null($subcategory_sub_subcategories[$key])) {
                                    $sub_subcategory->nombre = $subcategory_sub_subcategories[$key];
                                    $sub_subcategory->save();
                                } else {
                                    if (count($sub_subcategory->products) > 0) {
                                        return back()->withErrors(['La sub-subcategoría ' . $sub_subcategory->nombre . ' no se puede eliminar porque tiene productos asignados.']);
                                    } else {
                                        $sub_subcategory->delete();
                                    }
                                }
                            }

                            for ($i = count($subcategory->subcategories); $i < count($subcategory_sub_subcategories); $i++) {
                                $sub_subcategory = new Category;
                                $sub_subcategory->nombre = $subcategory_sub_subcategories[$i];
                                $sub_subcategory->padre = $subcategory->id;
                                $sub_subcategory->save();
                            }
                        }
                    } else {
                        if (count($subcategory->products) > 0) {
                            return back()->withErrors(['La subcategoría ' . $subcategory->nombre . ' no se puede eliminar porque tiene productos asignados.']);
                        } else {
                            $products = 0;

                            foreach ($subcategory->subcategories as $sub_subcategory) {
                                $products += count($sub_subcategory->products);
                            }

                            if ($products > 0) {
                                return back()->withErrors(['La subcategoría ' . $subcategory->nombre . ' no se puede eliminar porque alguna de sus sub-subcategorías tiene productos asignados.']);
                            }
                        }

                        foreach ($subcategory->subcategories as $sub_subcategory) {
                            $sub_subcategory->delete();
                        }

                        $subcategory->delete();
                    }
                }

                if (is_array($subcategories)) {
                    for ($i = count($category->subcategories); $i < count($subcategories); $i++) {
                        $subcategory = new Category;
                        $subcategory->nombre = $subcategories[$i];
                        $subcategory->padre = $category->id;

                        if ($subcategory->save()) {
                            $subcategory_sub_subcategories = [];

                            if (is_array($sub_subcategories) && array_key_exists($i, $sub_subcategories) && !is_null($sub_subcategories[$i])) {
                                $subcategory_sub_subcategories = explode(',', $sub_subcategories[$i]);
                            }

                            foreach ($subcategory_sub_subcategories as $value) {
                                $sub_subcategory = new Category;
                                $sub_subcategory->nombre = $value;
                                $sub_subcategory->padre = $subcategory->id;
                                $sub_subcategory->save();
                            }
                        }
                    }
                }

                return redirect()->route('admin.categories.index')->with('success', "La categoría {$category->nombre} se actualizó con éxito.");
            }
        }

        return back()->with('danger', 'Ha ocurrido un error.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::with(['subcategories'])->where([
            'id' => $id,
            'padre' => null,
        ])->first();

        if (!is_null($category)) {
            if (count($category->products) > 0) {
                return back()->withErrors(['La categoría ' . $category->nombre . ' no se puede eliminar porque tiene productos asignados.']);
            } else {
                foreach ($category->subcategories as $key => $subcategory) {
                    if (count($subcategory->products) > 0) {
                        return back()->withErrors(['La categoría ' . $category->nombre . ' no se puede eliminar porque alguna de sus subcategorías tiene productos asignados.']);
                    } else {
                        foreach ($subcategory->subcategories as $sub_subcategory) {
                            if (count($sub_subcategory->products) > 0) {
                                return back()->withErrors(['La categoría ' . $category->nombre . ' no se puede eliminar porque alguna de sus sub-subcategorías tiene productos asignados.']);
                            }
                        }
                    }
                }
            }

            foreach ($category->subcategories as $subcategory) {
                foreach ($subcategory->subcategories as $sub_subcategory) {
                    $sub_subcategory->delete();
                }

                $subcategory->delete();
            }

            $category->delete();

            return redirect()->route('admin.categories.index')->with('success', "La categoría {$category->nombre} se eliminó con éxito.");
        }

        return redirect()->route('admin.categories.index')->with('danger', 'Ha ocurrido un error.');
    }
}

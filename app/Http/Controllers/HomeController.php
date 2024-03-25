<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Berita;
use App\Models\Page;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $menu = $this->getMenu();
        $berita = Berita::with('kategori')->latest()->take(6)->get();
        $mostViews = Berita::with('kategori')->orderByDesc('total_views')->take(3)->get();
        return view('frontend.content.home', compact('menu', 'berita', 'mostViews'));
    }

    public function detailBerita($id)
    {
        $menu = $this->getMenu();
        $berita = Berita::findOrFail($id);

        // Update total_view
        $berita->total_views = $berita->total_views + 1;
        $berita->save();

        return view('frontend.content.detailBerita', compact('menu', 'berita'));
    }

    public function detailPage($id)
    {
        $menu = $this->getMenu();
        $page = Page::findOrFail($id);
        return view('frontend.content.detailPage', compact('menu', 'page'));
    }

    public function semuaBerita()
    {
        $menu = $this->getMenu();
        $berita = Berita::with('kategori')->latest()->get();
        return view('frontend.content.semuaBerita', compact('menu', 'berita'));
    }

    private function getMenu()
    {
        $menu = Menu::whereNull('parent_menu')
            ->with(['submenu' => function ($q) {
                $q->where('status_menu', '=', 1)
                    ->orderBy('urutan_menu', 'asc');
            }])
            ->where('status_menu', '=', 1)
            ->orderBy('urutan_menu', 'asc')
            ->get();

        $dataMenu = [];
        foreach ($menu as $m) {
            $jenis_menu = $m->jenis_menu;
            $urlMenu = "";

            if ($jenis_menu == "url") {
                $urlMenu = $m->url_menu;
            } else {
                $urlMenu = route('home.detailPage', $m->url_menu);
            }

            $dItemMenu = [];
            foreach ($m->submenu as $im) {
                $jenisItemMenu = $im->jenis_menu;
                $urlItemMenu = "";

                if ($jenisItemMenu == "url") {
                    $urlItemMenu = $im->url_menu;
                } else {
                    $urlItemMenu = route('home.detailPage', $im->url_menu);
                }

                $dItemMenu[] = [
                    'sub_menu_nama' => $im->nama_menu,
                    'sub_menu_target' => $im->target_menu,
                    'sub_menu_url' => $urlItemMenu,
                ];
            }

            $dataMenu[] = [
                'menu' => $m->nama_menu,
                'target' => $m->target_menu,
                'url' => $urlMenu,
                'itemMenu' => $dItemMenu
            ];
        }
        return $dataMenu;
    }
}

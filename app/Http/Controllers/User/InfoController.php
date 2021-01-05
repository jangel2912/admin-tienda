<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Vendty\Shop;
use App\Models\Vendty\SocialNetwork;
use App\Shop\ContactUs;
use Illuminate\Http\Request;

class InfoController extends Controller
{
    public function getAboutus()
    {
        $aboutUs = (!is_null(auth()->user()->dbConfig->shop)) ? auth()->user()->dbConfig->shop->descripcionQuienesSomos : null;
        return view('admin.info.about-us', compact('aboutUs'));
    }

    public function setAboutus(Request $request)
    {
        $aboutUs = auth()->user()->dbConfig->shop;
        if (is_null($aboutUs)) {
            $aboutUs = new Shop;
        }

        $aboutUs->descripcionQuienesSomos = $request->about_us;

        if ($aboutUs->save()) {
            return back()->with('success', 'Los datos se actualizaron con éxito.');
        } else {
            return back()->with('error', message('error'));
        }
    }

    public function getContactus()
    {
        $contactUs = ContactUs::first();
        return view('admin.info.contact-us', compact('contactUs'));
    }

    public function setContactus(Request $request)
    {
        $contactUs = ContactUs::first();
        if (is_null($contactUs)) {
            $contactUs = new ContactUs;
        }

        $contactUs->google_maps = $request->google_maps;
        $contactUs->address = $request->address;
        $contactUs->prefix_phone = $request->prefix_phone;
        $contactUs->phone = $request->phone;
        $contactUs->prefix_cellphone = $request->prefix_cellphone;
        $contactUs->cellphone =$request->cellphone;
        $contactUs->prefix_whatsapp = $request->prefix_whatsapp;
        $contactUs->whatsapp = $request->whatsapp;
        $contactUs->whatsapp_default_message = $request->whatsapp_default_message;
        $contactUs->email = $request->email;

        if ($contactUs->save()) {
            return back()->with('success', 'Los datos se actualizaron con éxito.');
        } else {
            return back()->with('error', message('error'));
        }
    }

    public function getSocialNetworks()
    {
        $social = SocialNetwork::where('id_user', auth_user()->id)->first();
        return view('admin.info.social-networks', compact('social'));
    }

    public function setSocialNetworks(Request $request)
    {
        $social = SocialNetwork::where('id_user', auth_user()->id)->first();
        if (is_null($social)) {
            $social = new SocialNetwork;
        }

        $social->facebook = $request->facebook;
        $social->instagram = $request->instagram;
        $social->linkedin = $request->linkedin;
        $social->twitter = $request->twitter;
        $social->youtube = $request->youtube;
        $social->pinterest = $request->pinterest;
        $social->id_user = auth_user()->id;
        $social->id_db = auth_user()->dbConfig->id;
        $social->id_almacen = auth_user()->shop->id_almacen;

        if ($social->save()) {
            return back()->with('success', '¡Los datos se actualizaron con éxito!');
        } else {
            return back()->with('error', message('error'));
        }
    }

    public function getTerms()
    {
        $terms = (!is_null(auth()->user()->dbConfig->shop)) ? auth()->user()->dbConfig->shop->terminos_condiciones : null;
        return view('admin.info.terms', compact('terms'));
    }

    public function setTerms(Request $request)
    {
        $terms = auth()->user()->dbConfig->shop;
        if (is_null($terms)) {
            $terms = new Shop;
        }

        $terms->terminos_condiciones = $request->terms;

        if ($terms->save()) {
            return back()->with('success', 'Los datos se actualizaron con éxito.');
        } else {
            return back()->with('error', message('error'));
        }
    }
}

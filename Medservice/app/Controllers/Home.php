<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        // ส่งเกณฑ์จาก config ที่เดียวเข้า view แทนการ hardcode ในหน้าเว็บ
        return view('index', [
            'refRanges'  => (new \Config\ReferenceRangeConfig())->toLegacyJsRows(),
            'refVersion' => (new \Config\ReferenceRangeConfig())->version,
            'refGroups'  => (new \Config\ReferenceRangeConfig())->groups,
        ]);
    }

    public function Hello(): string
    {
        return "Hello Bee";
    }
}

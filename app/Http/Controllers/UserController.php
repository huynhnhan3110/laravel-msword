<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;
class UserController extends Controller
{
    public function index() {
        $users = User::all();
        return view('users.index', compact('users'));
    }
    public function show($id) {
        $user = User::find($id);
        return view('users.show', compact('user'));
    }

    public function exportWord($id) {
        $user = User::find($id);
        $templateProcessor = new TemplateProcessor('word-template/maudon.docx');
        $templateProcessor->setValue('id', $user->id);
        $templateProcessor->setValue('name', $user->name);
        $templateProcessor->setValue('email', $user->email);
        $templateProcessor->setValue('address', $user->address);
        $fileName = $user->name;
        $templateProcessor->saveAs($fileName.'.docx');
        return response()->download($fileName.'.docx')->deleteFileAfterSend(true);
    }
}

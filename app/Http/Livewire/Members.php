<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Member;

class Members extends Component
{
    public $members, $name, $email, $phone_number, $status, $member_id;
    public $isModal = 0;

    //FUNGSI INI UNTUK MELOAD VIEW YANG ADA PADA TAMPILAN HALAMAN MEMBER
    public function render()
    {
        $this->members = Member::orderBy('created_at', 'DESC')->get(); //MEMBUAT QUERY UNTUK MENGAMBIL DATA
        return view('livewire.members'); //LOAD VIEW MEMBERS.BLADE.PHP YANG ADA PADA FOLDER /RESOURCES/VIEWS/LIVEWIRE
    }

    public function create()
    {
        $this->resetFields(); //FUNSI UNTUK MENGOSONGKAN FIELD
        $this->openModal(); //FUNGSI UNTUK MEMBUKA MODAL
    }

    public function closeModal()
    {
        $this->isModal = false;
    }

    public function openModal()
    {
        $this->isModal = true;
    }

    public function resetFields()
    {
        $this->name = '';
        $this->email = '';
        $this->phone_number = '';
        $this->status = '';
        $this->member_id = '';
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:members,email,' .$this->member_id,
            'phone_number' => 'required|numeric',
            'status' => 'required'
        ]);

        Member::updateOrCreate(['id' => $this->member_id], [
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'status' => $this->status,
        ]);

        session()->flash('message', $this->member_id ? $this->name . ' Diperbarui' : $this->name . ' Ditambahkan');
        $this->closeModal();
        $this->resetFields();
    }

    public function edit($id)
    {
        $member = Member::find($id);
        $this->member_id = $id;
        $this->name = $member->name;
        $this->email = $member->email;
        $this->phone_number = $member->phone_number;
        $this->status = $member->status;

        $this->openModal();
    }

    public function delete($id)
    {
        $member = Member::find($id);
        $member->delete();
        session()->flash('message', $member->name . ' Dihapus');
    }
}

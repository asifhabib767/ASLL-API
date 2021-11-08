<?php

namespace Modules\Contact\Repositories;

use App\Helpers\UploadHelper;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Modules\Contact\Entities\Contact;
use Modules\Contact\Entities\ContactGroup;
use Modules\Contact\Entities\Document;

class ContactRepository
{

    public function getContacts(Request $request)
    {
        try {
            $contacts = Contact::where('intCreatedBy', $request->intUserId)
                ->where('intCreatedAtUserTypeId', $request->intUserTypeId)
                ->orderBy('intID', 'desc')
                ->get();
            return $contacts;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getContactGroup()
    {
        try {
            $contactGroup = ContactGroup::get();
            return $contactGroup;
        } catch (\Exception $e) {
            return false;
        }
    }


    public function contactStoreImage(Request $request)
    {
        $images = null;
        if (!is_null($request->file)) {
            $images = UploadHelper::upload('file', $request->file('file'),  'contact-'.time(), 'contact-images');
        }
        // Document
        $url = url('contact-images/'.$images);

        $document = new Document();
        $document->strFileName = 'contact-'.time();
        $document->strFilePublicURL = $url;
        $document->intCreatedBy = $request->intCreatedBy;
        $document->intCreatedUserTypeId = $request->intCreatedUserTypeId;
        $document->save();

        return $document;
      }

    /**
     * store new vessel to vessels
     *
     * @param Request $request
     * @return object vessel object which is created
     */
    public function store(Request $request)
    {
        // return $request->all();
        try {
            $contact = Contact::create([
                'intGroupId' => (int)$request->intGroupId,
                'strGroupName' => $request->strGroupName,
                'strCustomerName' => $request->strCustomerName,
                'strOrganizationName' => $request->strOrganizationName,
                'strDesignation' => $request->strDesignation,
                'strContactNo' => $request->strContactNo,
                'strEmail' => $request->strEmail,
                'strLatitude' => $request->strLatitude,
                'strLongitude' => $request->strLongitude,
                'image' => $request->image,
                'intCreatedBy'=> (int)$request->intCreatedBy,
                'intCreatedAtUserTypeId'=> (int)$request->intCreatedAtUserTypeId,
                'ysnActive'=> $request->ysnActive,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            return $contact;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * update Contact by id
     *
     * @param Request $request
     * @param integer $id
     * @return object updated Contact object
     */
    public function updateContact(Request $request, $id)
    {

        try {
            $contact = $this->show($id);
            if(!is_null($contact)){
                Contact::where('intID', $id)
                ->update([
                    'intGroupId' => (int)$request->intGroupId,
                    'strGroupName' => $request->strGroupName,
                    'strCustomerName' => $request->strCustomerName,
                    'strOrganizationName' => $request->strOrganizationName,
                    'strDesignation' => $request->strDesignation,
                    'strContactNo' => $request->strContactNo,
                    'strEmail' => $request->strEmail,
                    'strLatitude' => $request->strLatitude ? $request->strLatitude : $contact->strLatitude,
                    'strLongitude' => $request->strLongitude ? $request->strLongitude : $contact->strLongitude,
                    'image' => $request->image ? $request->image : $contact->image,
                    'intUpdatedBy'=> (int)$request->intUpdatedBy,
                    'intUpdatedAtUserTypeId'=> (int)$request->intUpdatedAtUserTypeId,
                    'updated_at' => Carbon::now(),
                ]);
            }

            return $this->show($id);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * show Contact by id
     *
     * @param integer $id
     * @return object voyage activity boiler object
     */
    public function show($id)
    {
        try {
            $contact = Contact::find($id);
            return $contact;
        } catch (\Exception $e) {
            throw new \Exception('Sorry, Contact Not Found !');
        }
    }
}

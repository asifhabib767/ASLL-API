<?php

namespace Modules\Contact\Http\Controllers;

use App\Repositories\ResponseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Modules\Contact\Repositories\ContactRepository;

class ContactController extends Controller
{

    public $contactRepository;
    public $responseRepository;


    public function __construct(ContactRepository $contactRepository, ResponseRepository $rp)
    {
        $this->contactRepository = $contactRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\GET(
     *     path="/api/v1/contact/contacts/getContacts",
     *     tags={"Contact"},
     *     summary="Get Contact",
     *     description="Get Contact",
     *     operationId="getContacts",
     *     security={{"bearer": {}}},
     *     @OA\Parameter( name="intUserId", description="intUserId, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter( name="intUserTypeId", description="intUserTypeId, eg; 1", required=true, in="query", @OA\Schema(type="integer")),
     *     @OA\Response(response=200,description="Get Module Permissions By User Type"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getContacts(Request $request)
    {

        try {
            $data = $this->contactRepository->getContacts($request);
            return $this->responseRepository->ResponseSuccess($data, 'Get Contacts Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/contact/contacts/getContactGroup",
     *     tags={"Contact"},
     *     summary="Get Contact",
     *     description="Get Contact",
     *     operationId="getContactGroup",
     *     @OA\Response(response=200,description="Get Module Permissions By User Type"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getContactGroup()
    {

        try {
            $data = $this->contactRepository->getContactGroup();
            return $this->responseRepository->ResponseSuccess($data, 'Get Contacts Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('customer::create');
    }

    /**
     * @OA\POST(
     *     path="/api/v1/contact/contacts/store",
     *     tags={"Contact"},
     *     summary="Create Contact",
     *     description="Create Contact",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intGroupId", type="integer", example=1),
     *              @OA\Property(property="strGroupName", type="string", example="Distribution"),
     *              @OA\Property(property="strCustomerName", type="string", example="Abir Ahmad"),
     *              @OA\Property(property="strOrganizationName", type="string", example="XYZ Store"),
     *              @OA\Property(property="strDesignation", type="string", example="Executive"),
     *              @OA\Property(property="strContactNo", type="string", example="01837834893"),
     *              @OA\Property(property="strLatitude", type="string", example="East"),
     *              @OA\Property(property="strLongitude", type="string", example="SE"),
     *              @OA\Property(property="strEmail", type="string", example="contact@gmail.com"),
     *              @OA\Property(property="image", type="string", example="/image"),
     *              @OA\Property(property="intCreatedBy", type="integer", example=1),
     *              @OA\Property(property="intCreatedAtUserTypeId", type="integer", example=1),
     *              @OA\Property(property="ysnActive", type="boolean", example=1),
     *           )
     *      ),
     *      operationId="store",
     *      @OA\Response(response=200,description="Create Contact"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function store(Request $request)
    {
        try {
            $data = $this->contactRepository->store($request);
            return $this->responseRepository->ResponseSuccess($data, 'Contact Created Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\POST(
     *     path="/api/v1/contact/contacts/contactStoreImage",
     *     tags={"Contact"},
     *     summary="Create Contact Image",
     *     description="Create Contact Image",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="file", type="string", example="/image"),
     *              @OA\Property(property="intCreatedBy", type="integer", example=null),
     *              @OA\Property(property="intCreatedUserTypeId", type="integer", example=null),
     *           )
     *      ),
     *      operationId="contactStoreImage",
     *      @OA\Response(response=200,description="Create Contact Image"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function contactStoreImage(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|image|max:1024',
            ]);

            $data = $this->contactRepository->contactStoreImage($request);
            return $this->responseRepository->ResponseSuccess($data, 'Images Added Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/v1/contact/contacts/updateContact",
     *     tags={"Contact"},
     *     summary="Update Contact",
     *     description="Update Contact",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="intID", type="integer", example=1),
     *              @OA\Property(property="intGroupId", type="integer", example=1),
     *              @OA\Property(property="strGroupName", type="string", example="Distribution"),
     *              @OA\Property(property="strCustomerName", type="string", example="Abir Ahmad"),
     *              @OA\Property(property="strOrganizationName", type="string", example="XYZ Store"),
     *              @OA\Property(property="strDesignation", type="string", example="Executive"),
     *              @OA\Property(property="strContactNo", type="string", example="01837834893"),
     *              @OA\Property(property="strLatitude", type="string", example="East"),
     *              @OA\Property(property="strLongitude", type="string", example="SE"),
     *              @OA\Property(property="strEmail", type="string", example="contact@gmail.com"),
     *              @OA\Property(property="image", type="string", example="/image"),
     *              @OA\Property(property="intCreatedBy", type="integer", example=1),
     *              @OA\Property(property="intCreatedAtUserTypeId", type="integer", example=1),
     *              @OA\Property(property="ysnActive", type="boolean", example=1),
     *              )
     *      ),
     *      operationId="updateContact",
     *      @OA\Response(response=200,description="Update Contacts"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function updateContact(Request $request)
    {
        try {
            $data = $this->contactRepository->updateContact($request, $request->intID);
            return $this->responseRepository->ResponseSuccess($data, 'Contacts Updated Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }





    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('customer::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('customer::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}

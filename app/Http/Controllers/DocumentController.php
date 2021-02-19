<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Document;

/**
 * @OA\Schema(
 *   schema="DocumentSchema",
 *   title="Document Model",
 *   description="Document controller",
 *   @OA\Property(
 *     property="idDocument", description="ID of the document",
 *     type="integer",
 *     @OA\Schema(type="number", example=1)
 *   ),
 *   @OA\Property(
 *      property="documentType", description="Type of the document",
 *      type="string",
 *      @OA\Schema(type="string", example="Contrat")
 *   ),
 *   @OA\Property(
 *      property="documentURL", description="URL of the document",
 *      type="string",
 *      @OA\Schema(type="string", example="img.png")
 *   ),
 *   @OA\Property(
 *      property="idUser", description="Id of the User",
 *      type="integer",
 *      @OA\Schema(type="int", example="1")
 *  )
 * )
 */
class DocumentController extends Controller
{
    /**
     * @OA\Post(
     *   path="/api/v1/document",
     *   summary="Create a document",
     *   tags={"Documents"},
     *   security={{"bearer_token":{}}},
     *      @OA\RequestBody(
     *         @OA\JsonContent(
     *           @OA\Property(
     *               property="documentType",
     *                description="Type of the document",
     *                example="Test",
     *               type="string"
     *          ),
     *          @OA\Property(
     *             property="documentURL",
     *             description="URL of the document",
     *             example="test/truc",
     *             type="string"
     *          ),
     *          @OA\Property(
     *             property="idUser",
     *             description="Id of the User",
     *             example="1",
     *             type="integer"
     *          )
     *        )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Document created"      
     *      ),
     *      @OA\Response(
     *          response=409,
     *          description="Document Registration Failed !"
     *      )
     *    )
     * )
    */
    public function createDocument(Request $request) {
         //validate incoming request 
         $this->validate($request, [
            'documentType' => 'required|string', 
            'documentURL' => 'required|string', 
            'idUser' => 'required|integer',
        ]);

        try {
           
            $document = new Document;
            $document->documentType = $request->input('documentType');
            $document->documentURL = $request->input('documentURL');
            $document->idUser = $request->input('idUser');
            
            $document->save();

            //return successful response
            return response()->json(['document' => $document, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'Document Registration Failed!'], 409);
        }
    }


    /**
     * @OA\Get(
     *   path="/api/v1/documents",
     *   summary="Return the list of documents",
     *   tags={"Documents"},
     *   security={{"bearer_token":{}}},
     *      @OA\Response(
     *      response=200,
     *      description="List of documents"      
     *      )
     *    )
     * )
    */
    public function allDocuments()
    {
        return response()->json(['document' =>  Document::all()], 200);
    }

    /**
     * @OA\Get(
     *   path="/api/v1/document/{idDocument}",
     *   summary="Return a document",
     *   tags={"Documents"},
     *   security={{"bearer_token":{}}},
     *   @OA\Parameter(
     *      parameter="idDocument",
     *      name="idDocument",
     *      description="Id of a specific document",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *          type="integer",
     *          format="int64",
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *      description="Successfull operation"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="Document not found !"
     *   ),
     * )
    */
    public function singleDocument($idDocument)
    {
        try {
            $document = Document::findOrFail($idDocument);

            return response()->json(['document' => $document], 200);
        } catch (\Exception $e) {

            return response()->json(['message' => 'Document not found !'], 404);
        }
    }

    /**
     * @OA\Delete(
     *   path="/api/v1/document/{idDocument}",
     *   summary="Delete a document",
     *   tags={"Documents"},
     *   security={{"bearer_token":{}}},
     *   @OA\Parameter(
     *      parameter="idDocument",
     *      name="idDocument",
     *      description="Id of a specific document",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *          type="integer",
     *          format="int64",
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *      description="Document deleted"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="Document not found !"
     *   ),
     * )
    */
    public function deleteDocument($idDocument) 
    {
        try {
            Document::findOrFail($idDocument)->delete();
            return response()->json(['message' => 'Document deleted'], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Document not found!'], 404);
        }
    }

    /**
     * @OA\Put(
     *   path="/api/v1/document/{idDocument}",
     *   summary="Update a document",
     *   tags={"Documents"},
     *   security={{"bearer_token":{}}},
     *   @OA\Parameter(
     *      parameter="idDocument",
     *      name="idDocument",
     *      description="Id of a specific document",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *          type="integer",
     *          format="int64",
     *      )
     *   ),
     *   @OA\RequestBody(
     *         @OA\JsonContent(
     *           @OA\Property(
     *               property="documentType",
     *                description="Type of the document",
     *                example="Test",
     *               type="string"
     *          ),
     *          @OA\Property(
     *             property="documentURL",
     *             description="URL of the document",
     *             example="test/truc",
     *             type="string"
     *          ),
     *          @OA\Property(
     *             property="idUser",
     *             description="Id of the User",
     *             example="1",
     *             type="integer"
     *          )
     *        )
     *      ),
     *   @OA\Response(
     *      response=200,
     *      description="Document updated"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="Document not found !"
     *   ),
     * )
    */
    public function updateDocument($idDocument, Request $request)
    {
        try {
            $document = Document::findOrFail($idDocument);
            $document->update($request->all());

            return response()->json(['document' => $document], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Document not found!'], 404);
        }
    }
}

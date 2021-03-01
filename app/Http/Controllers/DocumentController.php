<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Document;

/**
 * @OA\Schema(
 *      schema="Documents",
 *      title="Documents Model",
 *      description="Documents",
 *      @OA\Property(
 *          property="{idDocument}", description="ID of the Document",
 *          type="integer",
 *          @OA\Schema(type="number", example=1)
 *      ),
 *      @OA\Property(
 *          property="documentName", description="Name of the Document",
 *          type="string",
 *          @OA\Schema(type="string", example="Lumina Le Havre")
 *      ),
 *      @OA\Property(
 *          property="documentType", description="Document Type",
 *          type="integer",
 *          @OA\Schema(type="number", example=2)
 *      ),
 *      @OA\Property(
 *          property="documentURL", description="URL Document",
 *          type="string",
 *          @OA\Schema(type="string", example="urlwebsite/folder/namefile.pdf")
 *      ),
 *      @OA\Property(
 *          property="idUser", description="User related to the document",
 *          type="integer",
 *          @OA\Schema(type="number", example=2)
 *      ),
 * )
 */
class DocumentController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/v1/document",
     *      summary="Create one document",
     *      tags={"Documents"},     
     *      security={{"bearer_token":{}}},
     *      @OA\Parameter(
     *          parameter="documentType",
     *          name="documentType",
     *          description="documentType",
     *          in="query",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          )
     *      ), 
     *      @OA\Parameter(
     *          parameter="documentURL",
     *          name="documentURL",
     *          description="documentURL",
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          parameter="idUser",
     *          name="idUser",
     *          description="idUser",
     *          in="query",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Document created",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="idDocument",
     *                          type="integer",
     *                          description="Document ID"
     *                      ),
     *                      @OA\Property(
     *                          property="documentName",
     *                          type="string",
     *                          description="Document Name"
     *                      ),
     *                      @OA\Property(
     *                          property="documentType",
     *                          type="integer",
     *                          description="Document Type",
     *                      ),
     *                      example={
     *                          "document": {
     *                              {
     *                                  "idDocument": 1,
     *                                  "documentName": "Bail - Maison",
     *                                  "documentType": 1,
     *                                  "documentURL": "urlwebsite/folder/namefile.pdf",
     *                                  "idUser": 1,
     *                              },
     *                          }
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     *      @OA\Response(
     *          response="401",
     *          description="Unauthorized",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example="Unauthorized"
     *                  )
     *              )
     *          },
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="Document Registration Failed!",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example={
     *                          "message": "Document Registration Failed!"
     *                      }
     *                  )
     *              )
     *          },
     *      ),
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
            return response()->json(['document' => $document, 'message' => 'Document created'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'Document Registration Failed!'], 409);
        }
    }


    /**
     * @OA\Get(
     *      path="/api/v1/documents",
     *      summary="Return the list of document",
     *      tags={"Documents"},
     *      security={{"bearer_token":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Documents found",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="idDocument",
     *                          type="integer",
     *                          description="Document ID"
     *                      ),
     *                      @OA\Property(
     *                          property="documentName",
     *                          type="string",
     *                          description="Document Name"
     *                      ),
     *                      @OA\Property(
     *                          property="documentType",
     *                          type="integer",
     *                          description="Document Type",
     *                      ),
     *                      example={
     *                          "document": {
     *                              {
     *                                  "idDocument": 1,
     *                                  "documentName": "Bail - Maison",
     *                                  "documentType": 1,
     *                                  "documentURL": "urlwebsite/folder/namefile.pdf",
     *                                  "idUser": 1,
     *                              },
     *                              {
     *                                  "idDocument": 2,
     *                                  "documentName": "Bail - Villa",
     *                                  "documentType": 2,
     *                                  "documentURL": "urlwebsite/folder/namefile2.pdf",
     *                                  "idUser": 2,
     *                              },
     *                          }
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     *      @OA\Response(
     *          response="401",
     *          description="Unauthorized",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example="Unauthorized"
     *                  )
     *              )
     *          },
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="Documents not found!",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example={
     *                          "message": "Documents not found!"
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     *  )
     */
    public function allDocuments()
    {
        try {
            return response()->json(['document' =>  Document::all()], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Documents not found!'], 404);
        }
        
    }

    /**
     * @OA\Get(
     *      path="/api/v1/document/{idDocument}",
     *      summary="Return one document info",
     *      tags={"Documents"},
     *      security={{"bearer_token":{}}},
     *      @OA\Parameter(
     *          parameter="idDocument",
     *          name="idDocument",
     *          description="idDocument",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Document found",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="idDocument",
     *                          type="integer",
     *                          description="Document ID"
     *                      ),
     *                      @OA\Property(
     *                          property="documentName",
     *                          type="string",
     *                          description="Document Name"
     *                      ),
     *                      @OA\Property(
     *                          property="documentType",
     *                          type="integer",
     *                          description="Document Type",
     *                      ),
     *                      example={
     *                          "document": {
     *                              {
     *                                  "idDocument": 1,
     *                                  "documentName": "Bail - Maison",
     *                                  "documentType": 1,
     *                                  "documentURL": "urlwebsite/folder/namefile.pdf",
     *                                  "idUser": 1,
     *                              },
     *                          }
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     *      @OA\Response(
     *          response="401",
     *          description="Unauthorized",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example="Unauthorized"
     *                  )
     *              )
     *          },
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="Document not found!",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example={
     *                          "message": "Document not found!"
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     * )
     */
    public function singleDocument($idDocument)
    {
        try {
            $document = Document::findOrFail($idDocument);

            return response()->json(['document' => $document], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Document not found!'], 404);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/document/{idDocument}",
     *      summary="Delete one document",
     *      tags={"Documents"},     
     *      security={{"bearer_token":{}}}, 
     *      @OA\Parameter(
     *          parameter="idDocument",
     *          name="idDocument",
     *          description="idDocument",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Document deleted",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example={
     *                          "message": "Document deleted"
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     *      @OA\Response(
     *          response="401",
     *          description="Unauthorized",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example="Unauthorized"
     *                  )
     *              )
     *          },
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="Document not deleted!",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example={
     *                          "message": "Document not deleted!"
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     * )
     */
    public function deleteDocument($idDocument) 
    {
        try {
            Document::findOrFail($idDocument)->delete();
            return response()->json(['message' => 'Document deleted'], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Document not deleted!'], 404);
        }
    }

    /**
     * @OA\Put(
     *      path="/api/v1/document/{idDocument}",
     *      summary="Update one Document",
     *      tags={"Documents"},     
     *      security={{"bearer_token":{}}},
     *      @OA\Parameter(
     *          parameter="idDocument",
     *          name="idDocument",
     *          description="idDocument",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          )
     *      ),
     *      @OA\Parameter(
     *          parameter="documentType",
     *          name="documentType",
     *          description="documentType",
     *          in="query",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          )
     *      ), 
     *      @OA\Parameter(
     *          parameter="documentURL",
     *          name="documentURL",
     *          description="documentURL",
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          parameter="idUser",
     *          name="idUser",
     *          description="idUser",
     *          in="query",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Document found",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="idDocument",
     *                          type="integer",
     *                          description="Document ID"
     *                      ),
     *                      @OA\Property(
     *                          property="documentName",
     *                          type="string",
     *                          description="Document Name"
     *                      ),
     *                      @OA\Property(
     *                          property="documentType",
     *                          type="integer",
     *                          description="Document Type",
     *                      ),
     *                      example={
     *                          "document": {
     *                              {
     *                                  "idDocument": 1,
     *                                  "documentName": "Bail - Maison",
     *                                  "documentType": 1,
     *                                  "documentURL": "urlwebsite/folder/namefile.pdf",
     *                                  "idUser": 1,
     *                              },
     *                          }
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     *      @OA\Response(
     *          response="401",
     *          description="Unauthorized",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example="Unauthorized"
     *                  )
     *              )
     *          },
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="Document not updated!",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example={
     *                          "message": "Document not updated!"
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     * )
     */
    public function updateDocument($idDocument, Request $request)
    {
        try {
            $document = Document::findOrFail($idDocument);
            $document->update($request->all());

            return response()->json(['document' => $document], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Document not updated!'], 404);
        }
    }
}

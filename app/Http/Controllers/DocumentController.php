<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Document;

class DocumentController extends Controller
{
    /**
     * Store a new document.
     *
     * @param  Request  $request
     * @return Response
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
     * Get all Documents.
     *
     * @return Response
     */
    public function allDocuments()
    {
        return response()->json(['document' =>  Document::all()], 200);
    }

    /**
     * Get one property.
     *
     * @return Response
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
     * Remove Document.
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

    public function updateDocument($idDocument, Request $request)
    {
        try {
            $document = Document::findOrFail($idDocument);
            $document->update($request->all());

            return response()->json(['document' => $document], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'user not found!'], 404);
        }
    }
}

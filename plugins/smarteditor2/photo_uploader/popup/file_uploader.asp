<%@Language="VBScript" CODEPAGE="65001" %> 
<% 
Response.CharSet="utf-8" 
Session.codepage="65001" 
Response.codepage="65001" 
Response.ContentType="text/html;charset=utf-8" 

Response.Expires = -10000
Server.ScriptTimeOut = 7200
%>




<!-- #include virtual = "/_public/public_variable.asp" -->


<%    


'=================================================
'ABCUpload
Set up = Server.CreateObject("ABCUpload4.XForm")
up.AbsolutePath = True	'절대경로 사용가능
up.Overwrite	= True  '덮어쓰기 가능
up.CodePage		= 65001    '한글파일 가능하게
up.MaxUploadSize = 10485760 '파일 허용 용량(이 크기와는 별개로 아래 코드상에서 제한함)
'=================================================

'//파일 저장 경로
file_path = "/files/board/editor" 

url = "./callback.html" & "?callback_func=" & up("callback_func")   


'//////////////////////////////////////////////////////////////////////////////////
'// 파일관련 처리 START 
'////////////////////////////////// ///////////////////////////////////////////////

If up("Filedata").Count >= 1 Then 

	'//파일 저장 반복문
	For i = 1 To up("Filedata").Count
		
		Set theField = up("Filedata")(i)

		If theField.FileExists Then

			DirectoryPath = server.mappath("/") & Replace(file_path,"/","\")
			strFileName   = theField.SafeFileName
			
			'//파일 용량 체크
			U_FileSize = theField.Length
			If U_FileSize > UPLOAD_LIMMIT * 1024 * 1024 Then
			 Page_Msg_Back UPLOAD_LIMMIT&"M 이상 파일은 업로드하실 수 없습니다."
			 Response.end
			End If


			'//파일 확장자 체크
			strExt  = Mid(strFileName, InstrRev(strFileName, ".") + 1)
			uploadType = "png,gif,jpg,jpeg" '업로드 허용 파일타입
			arrFileType = Split(uploadType, "," ) 'Split함수를 이용해 문자열을 구분자로 분리해 배열에 담습니다.
			
			notUpChk = False 
			For z = 0 To Ubound(arrFileType) 
				 If LCase(strExt) = LCase(arrFileType(z)) Then
					  notUpChk = True
				 End If
			Next 

			If notUpChk = False Then
				Page_Msg_Back "허용되지 않는 파일 확장자입니다.\n(" & uploadType & "만 허용)"
				Response.end
			End If 



			'//파일 이름 검증
			strFileWholePath = GetUniqueName(strFileName, DirectoryPath)

			'//실제 저장 처리
			theField.Save strFileWholePath

			'//저장된 파일이이름 가져와 DB에 저장할 이름 추출
			Set fs = server.CreateObject("Scripting.FileSystemObject")
			strFileName = fs.GetFileName(strFileWholePath)

			If i = 1 Then 
				U_FileName = U_FileName & strFileName
			ElseIf i > 1 Then 
				U_FileName = U_FileName & "," & strFileName
			End If 

		End If	

	Next 

End If 



Function GetUniqueName(byRef strFileName, DirectoryPath)
	Dim strName, strExt
	strName = Mid(strFileName, 1, InstrRev(strFileName, ".") - 1)
	strExt  = Mid(strFileName, InstrRev(strFileName, ".") + 1)
		
	Dim fso
	Set fso = Server.CreateObject("Scripting.FileSystemObject")

	Dim bExist : bExist = True
	'우선 같은이름의 파일이 존재한다고 가정
	Dim strFileWholePath : strFileWholePath = DirectoryPath & "\" & strName & "." & strExt
	'저장할 파일의 완전한 이름(완전한 물리적인 경로) 구성
	Dim countFileName : countFileName = 0
	'파일이 존재할 경우, 이름 뒤에 붙일 숫자를 세팅함.

	Do While bExist ' 우선 있다고 생각함.
		If (fso.FileExists(strFileWholePath)) Then ' 같은 이름의 파일이 있을 때
			countFileName = countFileName + 1 '파일명에 숫자를 붙인 새로운 파일 이름 생성
			strFileName = strName & "(" & countFileName & ")." & strExt
			strFileWholePath = DirectoryPath & "\" & strFileName
		Else
			bExist = False
		End If
	Loop
	GetUniqueName = strFileWholePath
End Function



Sub Page_Msg_Back(msg)
  'url = url & "&errstr=" & msg
  with response
	 .write "<script>"
	 .write "  alert('" & msg & "');" 
	 .write "</script>"

	 '.redirect url
	 .end
  End with
End Sub


'//////////////////////////////////////////////////////////////////////////////////
'// 파일관련 처리 END 
'////////////////////////////////// ///////////////////////////////////////////////


'url = url & "&bNewLine=true"
'url = url & "&sFileName="& server.URLencode(strFileName)
'url = url & "&sFileURL=" & FileUrl & file_path &"/" & server.URLencode(strFileName)
'url = url & "&dir="& file_path


url = url & "&bNewLine=true"
url = url & "&sFileName="& strFileName
url = url & "&sFileURL=" & FileUrl & file_path &"/" & strFileName
url = url & "&dir="& file_path


'response.write url 
response.redirect url



%>

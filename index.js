const { sign } =require('pdf-signer');
const {PDFDocument} = require("pdf-lib");
const fs = require('fs');
const unzipper=require('unzipper');
const extract = require('extract-zip');
var zipdir = require('zip-dir');
var Unrar = require('unrar');
const unrarp = require('unrar-promise'); 
var path = require('path');
var AdmZip = require("adm-zip");
const action = async () => {
  var uploadPath=__dirname+"/signingDashboard/public/uploads";
  var downloadPath=__dirname+"/signingDashboard/public/downloads";
  var files=await getallFilesinDirectory(uploadPath);
  if(files.length>0)
  {

    var pdffolderNames=await getFolderNames(files,uploadPath);
    
    for (let index = 0; index < pdffolderNames.length; index++) {
      const element = pdffolderNames[index];
      
      let filePath=uploadPath+'/'+element;
      
      var def= fs.readdirSync(filePath);
      if(def.includes(element))
      {
        filePath=filePath+'/'+element;
        uploadPath=uploadPath+'/'+element;
      }
      var allPdfs=await getAllPdfsFromDir(filePath);
      await signPdfs(allPdfs,uploadPath,element);
      var buffer = await zipdir(filePath, { saveTo: downloadPath+'/signed_'+element+'.zip'});
      
    }
  
    
    
  }
}


function signPdfs(allPdfs,path,currFolder)
{
return new Promise(async (resolve,reject)=>{
for (let index = 0; index < allPdfs.length; index++) {
  const element = allPdfs[index];
  let newpath=path+'/'+currFolder+'/'+element;
  var existingPdfBytes=fs.readFileSync(newpath);
  var pdfDoc = await PDFDocument.load(existingPdfBytes, {
ignoreEncryption: true,
});
  var pdfBytes = await pdfDoc.save({ useObjectStreams: false });
  fs.writeFileSync(path+'/'+currFolder + '/demo'+index+'.pdf', pdfBytes);
  let p12Buffer = fs.readFileSync(__dirname + '/sign_omv_com.pfx')
  let pdfBuffer = fs.readFileSync(path+'/'+currFolder + '/demo'+index+'.pdf');
  const signedPdf = sign(pdfBuffer, p12Buffer, 'Hoboetech#@!', {
    reason: '2',
    email: 'f.at.debitoren@omv.com',
    location: 'France',
    signerName: 'OMV',
    annotationAppearanceOptions: {
      //signatureCoordinates: ,
      signatureCoordinates:{ left: 50, bottom: 700, right: 800, top: 900 },
      signatureDetails: [
        {
          value: '',
          fontSize: 3,
          transformOptions: { rotate: 0, space: 1, tilt: 0, xPos: 70, yPos: 40 },
        }
      ],
    },
  });
  signedPdf.then((val)=>{
    
    fs.writeFileSync(path+'/'+currFolder+'/signed_'+element, val);
  });
  await fs.unlinkSync(path+'/'+currFolder + '/demo'+index+'.pdf');
  await fs.unlinkSync(path+'/'+currFolder+'/'+element);
  
}
resolve("SUCCESS");
});
}

function getallFilesinDirectory(path)
{
  var filesarray=new Array();
  return new Promise((resolve,reject)=>{
    fs.readdir(path, (err, files) => {
    if(!err)
    {
  files.forEach(file => {
    if(file!=null && file.split('.').pop()=='rar' || file!=null && file.split('.').pop()=='zip') 
      filesarray.push(file);
    
  });
  resolve(filesarray);
}
else{
  reject("Some Issue");
}
})
  });
}

 function getAllPdfsFromDir(path)
{
  
  var allpdfnames=new Array();
return new Promise((resolve,reject)=>{
  fs.readdir(path,async (err,files)=>{
    if(!err)
    {
      for (let index = 0; index < files.length; index++) {
        const element = files[index];
        if(element!=null && element.split('.').pop()=='pdf')
        {
          allpdfnames.push(element);
        } 
      }
      resolve(allpdfnames);
    }
  });
})
}


async function getFolderNames(files,uploadPath)
{
  
  var folderNamesArray1=new Array();
  return new Promise(async (resolve)=>{
    for (let i = 0; i< files.length; i++) {
    const file = files[i];
    var p=path.extname(file);
    let folderName=file.split('.').slice(0, -1).join('.');
    if(!fs.existsSync(uploadPath+'/'+folderName))
    {
      fs.mkdirSync(path.join(uploadPath+'/'+folderName));
    }
    else
    {
      //fs.rmdirSync(uploadPath+'/'+folderName,{recursive:true});
      fs.rmSync(uploadPath+'/'+folderName,{recursive:true});
      fs.mkdirSync(path.join(uploadPath+'/'+folderName));
    }
    if(p==".rar")
    {
    await unrarp.unrar(uploadPath+'/'+file,uploadPath+'/'+folderName);
    }
    else if(p==".zip")
    {
      
      var zip=new AdmZip(uploadPath+'/'+file);
      await zip.extractAllTo(uploadPath+'/'+folderName, /*overwrite*/ true)
    }
    fs.unlinkSync(uploadPath+'/'+file);
    await folderNamesArray1.push(folderName);
    
  }
  resolve(folderNamesArray1);
 
  });
}

//function getAllPdfsInDir

action().catch(console.error);
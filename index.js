const { sign } =require('pdf-signer');
const {PDFDocument} = require("pdf-lib");
const fs = require('fs');
const action = async () => {
  var existingPdfBytes=fs.readFileSync(`${__dirname}/223344.pdf`);
  console.log(existingPdfBytes);
	var pdfDoc = await PDFDocument.load(existingPdfBytes, {
ignoreEncryption: true,
});
	var pdfBytes = await pdfDoc.save({ useObjectStreams: false });
  fs.writeFileSync(__dirname + '/demo12.pdf', pdfBytes);
  let p12Buffer = fs.readFileSync(__dirname + '/sign_omv_com.pfx')
  let pdfBuffer = fs.readFileSync(`${__dirname}/demo12.pdf`);
  const signedPdf = sign(pdfBuffer, p12Buffer, 'Hoboetech#@!', {
  reason: '1',
  email: 'test@email.com',
  location: 'Location, LO',
  signerName: 'Test User',
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
  //console.log(val);
	fs.writeFileSync('./signed.pdf', val);
});
  
}

action();
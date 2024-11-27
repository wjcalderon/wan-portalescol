import { useState, useCallback } from 'react'
import { useDropzone } from 'react-dropzone'
import PropTypes from 'prop-types'

const fileTypes = {
  'image/png': ['.png'],
  'image/jpeg': ['.jpg', '.jpeg'],
  'application/pdf': ['.pdf'],
  'audio/mpeg': ['.mp3'],
  'video/mp4': ['.mp4'],
  'application/msword': ['.doc'],
  'application/vnd.openxmlformats-officedocument.wordprocessingml.document': ['.docx'],
  'application/vnd.ms-excel': ['.xls'],
  'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet': ['.xlsx'],
  'image/bmp': ['.bmp'],
  'application/vnd.ms-outlook': ['.msg'],
}

const UploadFiles = ({handleChange}) => {
  const [uploadedFiles, setUploadedFiles] = useState([])

  const onDrop = useCallback(
    acceptedFiles => {
      const fileList = []

      acceptedFiles.map(file => {
        let fileInfo = {
          attributes: {
            type: 'ContentVersion'
          },
          Title: file.name,
          PathOnClient: file.name,
          ContentLocation: "S",
          VersionData: ''
        }

        const fileReader = new FileReader()
        fileReader.readAsDataURL(file);
        fileReader.onload = () => {
          fileInfo.VersionData = btoa(fileReader.result)
        }

        fileList.push(fileInfo)
      })
      setUploadedFiles([...uploadedFiles, ...fileList])
      handleChange([...uploadedFiles, ...fileList])
    }, [uploadedFiles, handleChange])

  const { acceptedFiles, getRootProps, getInputProps } = useDropzone({
    accept: fileTypes,
    maxSize: 20971520, // 20MB
    onDrop,
  })

  const removeFile = (file) => () => {
    console.log('removeFile...')
    acceptedFiles.splice(acceptedFiles.indexOf(file), 1)
    setUploadedFiles(acceptedFiles)
    handleChange(uploadedFiles)
    console.log(acceptedFiles)
  }

  return (
    <div className="form-upload-files">
      <h3>Adjunta las imágenes correspondientes al evento natural ocurrido</h3>
      <section className="container">
        <div {...getRootProps({ className: 'dropzone' })}>
          <input {...getInputProps()} />
          <p>Arrastra archivos para adjuntar o búscalos en tu equipo</p>
          <span>
            <strong>Peso máximo permitido 20 MB.</strong> Formatos permitidos: .PDF, .JPG, .JPEG, .PNG, .MP4, .DOC, .DOCX, .XLS,. XLSX, .BMP, .MP3 y .MSG
          </span>
        </div>
      </section>

      <section className="uploaded-files">
        <h4>Archivos subidos</h4>
        <ul>
          {acceptedFiles.map(file => (
            <li key={file.path}>
              <p>
                <span>Documento</span>
                {file.name}
              </p>
              <p>
                <span>Tipo</span>
                {fileTypes[file.type]}
              </p>
              <button onClick={removeFile(file)}>Remove File</button>
            </li>
          ))}
        </ul>
      </section>
    </div>
  )
}

UploadFiles.propTypes = {
  handleChange: PropTypes.func,
}

export { UploadFiles }

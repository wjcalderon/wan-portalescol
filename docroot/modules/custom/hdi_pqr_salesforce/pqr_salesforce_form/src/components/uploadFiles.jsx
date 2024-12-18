import { useState, useCallback, useTransition } from 'react'
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

const UploadFiles = ({ handleChange }) => {
  const [uploadedFiles, setUploadedFiles] = useState([])
  const [isPending, startTransition] = useTransition()

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
          VersionData: '',
          type: fileTypes[file.type][0],
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
    maxFiles: 10,
    onDrop,
  })

  const removeFile = (file) => () => {
    startTransition(() => {
      uploadedFiles.splice(uploadedFiles.indexOf(file), 1)
      setUploadedFiles(uploadedFiles)
      handleChange(uploadedFiles)
    })
  }

  return (
    <div className="form-upload-files">
      <h3>Adjunta las imágenes correspondientes al evento natural ocurrido</h3>
      <section className="container">
        <div {...getRootProps({ className: 'dropzone' })}>
          <input {...getInputProps()} />
          <p>Arrastra archivos para adjuntar o <span>búscalos en tu equipo</span></p>
          <span>
            <strong>Peso máximo permitido 20 MB.</strong> Formatos permitidos: .PDF, .JPG, .JPEG, .PNG, .MP4, .DOC, .DOCX, .XLS,. XLSX, .BMP, .MP3 y .MSG
          </span>
        </div>
      </section>

      {!isPending && uploadedFiles.length > 0 &&
        <section className="uploaded-files">
          <h4>Archivos subidos</h4>
          <ul>
            {uploadedFiles.map(file => (
              <li key={file.path}>
                <p className="name">
                  <span>Documento</span>
                  {file.Title}
                </p>
                <p>
                  <span>Tipo</span>
                  {file.type}
                </p>
                <button onClick={removeFile(file)}>Remove File</button>
              </li>
            ))}
          </ul>
          <span className='bottom-text'>Arrastra más archivos para adjuntar o <i>búscalos en tu equipo</i></span>
        </section>
      }
    </div>
  )
}

UploadFiles.propTypes = {
  handleChange: PropTypes.func,
}

export { UploadFiles }

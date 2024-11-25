import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import './style.scss'
import App from './App.jsx'

createRoot(document.getElementById('block-hdi-portal-pqrsalesforceform')).render(
  <StrictMode>
    <App />
  </StrictMode>,
)

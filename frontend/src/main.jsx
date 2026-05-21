import React from 'react'
import ReactDOM from 'react-dom/client'
import { BrowserRouter } from 'react-router-dom'
import { Toaster } from 'react-hot-toast'
import App from './App.jsx'
import { AuthProvider } from './context/AuthContext.jsx'
import { SidebarProvider } from './context/SidebarContext.jsx'
import { ThemeProvider } from './context/ThemeContext.jsx'
import './index.css'

ReactDOM.createRoot(document.getElementById('root')).render(
  <React.StrictMode>
    <BrowserRouter>
      <ThemeProvider>
      <AuthProvider>
        <SidebarProvider>
        <App />
        <Toaster
          position="top-right"
          gutter={10}
          toastOptions={{
            duration: 3500,
            style: {
              borderRadius: '14px',
              padding: '14px 18px',
              fontSize: '14px',
              fontWeight: '500',
              boxShadow: '0 8px 32px rgba(0,0,0,0.14)',
              maxWidth: '380px',
              display: 'flex',
              alignItems: 'center',
              gap: '10px',
            },
            success: {
              style: {
                background: '#f0fdf4',
                color: '#15803d',
                border: '1.5px solid #bbf7d0',
                borderRadius: '14px',
                padding: '14px 18px',
                fontSize: '14px',
                fontWeight: '500',
                boxShadow: '0 8px 32px rgba(22,163,74,0.12)',
                maxWidth: '380px',
              },
              iconTheme: { primary: '#16a34a', secondary: '#f0fdf4' },
            },
            error: {
              style: {
                background: '#fef2f2',
                color: '#b91c1c',
                border: '1.5px solid #fecaca',
                borderRadius: '14px',
                padding: '14px 18px',
                fontSize: '14px',
                fontWeight: '500',
                boxShadow: '0 8px 32px rgba(220,38,38,0.12)',
                maxWidth: '380px',
              },
              iconTheme: { primary: '#dc2626', secondary: '#fef2f2' },
            },
          }}
        />
        </SidebarProvider>
      </AuthProvider>
      </ThemeProvider>
    </BrowserRouter>
  </React.StrictMode>,
)

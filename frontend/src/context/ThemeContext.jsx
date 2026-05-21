import { createContext, useContext, useEffect, useState } from 'react'

const ThemeContext = createContext()

export function ThemeProvider({ children }) {
  const [dark, setDark] = useState(() => localStorage.getItem('pgrkam_theme') === 'dark')

  useEffect(() => {
    if (dark) {
      document.documentElement.classList.add('dark')
      localStorage.setItem('pgrkam_theme', 'dark')
    } else {
      document.documentElement.classList.remove('dark')
      localStorage.setItem('pgrkam_theme', 'light')
    }
  }, [dark])

  return (
    <ThemeContext.Provider value={{ dark, toggleTheme: () => setDark(p => !p) }}>
      {children}
    </ThemeContext.Provider>
  )
}

export function useTheme() { return useContext(ThemeContext) }

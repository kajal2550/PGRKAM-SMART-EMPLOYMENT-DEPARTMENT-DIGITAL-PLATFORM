import { createContext, useContext, useState } from 'react'

const SidebarContext = createContext()

export function SidebarProvider({ children }) {
  const [sidebarOpen, setSidebarOpen] = useState(false)

  const toggleSidebar = () => setSidebarOpen(p => !p)
  const closeSidebar  = () => setSidebarOpen(false)

  return (
    <SidebarContext.Provider value={{ sidebarOpen, toggleSidebar, closeSidebar }}>
      {children}
    </SidebarContext.Provider>
  )
}

export function useSidebar() {
  return useContext(SidebarContext)
}

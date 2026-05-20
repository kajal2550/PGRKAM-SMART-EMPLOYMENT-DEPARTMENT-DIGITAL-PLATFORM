import { useState } from 'react'
import { Outlet } from 'react-router-dom'
import Navbar from '../components/Navbar'
import Sidebar from '../components/Sidebar'

/**
 * DashboardLayout – wraps all authenticated pages.
 * Shows the sidebar alongside the page content.
 */
export default function DashboardLayout() {
  const [sidebarOpen, setSidebarOpen] = useState(false)

  return (
    <div className="min-h-screen bg-gray-50">
      <Navbar
        onMenuClick={() => setSidebarOpen(!sidebarOpen)}
        sidebarOpen={sidebarOpen}
      />

      <div className="flex pt-16">
        <Sidebar isOpen={sidebarOpen} />

        {/* Page content – shifted right when sidebar is expanded on desktop */}
        <main
          className={`flex-1 transition-all duration-300 min-h-[calc(100vh-4rem)]
                      p-4 sm:p-6 lg:p-8
                      ${sidebarOpen ? 'lg:ml-64' : 'lg:ml-16'}`}
        >
          <Outlet />
        </main>
      </div>
    </div>
  )
}

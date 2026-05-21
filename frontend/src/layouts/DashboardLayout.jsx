import { Outlet } from 'react-router-dom'
import Navbar from '../components/Navbar'
import Sidebar from '../components/Sidebar'
import { useSidebar } from '../context/SidebarContext'

/**
 * DashboardLayout – wraps all authenticated pages.
 * Shows the sidebar alongside the page content.
 */
export default function DashboardLayout() {
  const { sidebarOpen, closeSidebar } = useSidebar()

  return (
    <div className="min-h-screen bg-gray-50">
      <Navbar />

      <div className="flex pt-16">
        <Sidebar isOpen={sidebarOpen} />

        {/* Overlay backdrop */}
        {sidebarOpen && (
          <div
            className="fixed inset-0 z-30 bg-black/30"
            onClick={closeSidebar}
          />
        )}

        {/* Page content */}
        <main className="flex-1 min-h-[calc(100vh-4rem)] p-4 sm:p-6 lg:p-8">
          <Outlet />
        </main>
      </div>
    </div>
  )
}

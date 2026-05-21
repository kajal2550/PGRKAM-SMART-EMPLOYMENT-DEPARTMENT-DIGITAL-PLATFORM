import { Outlet } from 'react-router-dom'
import Navbar from '../components/Navbar'
import Footer from '../components/Footer'
import QueryBox from '../components/QueryBox'
import Sidebar from '../components/Sidebar'
import { useAuth } from '../context/AuthContext'
import { useSidebar } from '../context/SidebarContext'

/**
 * MainLayout – wraps all public-facing pages (Home, About, Services, etc.)
 * When user is authenticated, the sidebar is available as an overlay.
 */
export default function MainLayout() {
  const { isAuthenticated } = useAuth()
  const { sidebarOpen, closeSidebar } = useSidebar()

  return (
    <div className="min-h-screen flex flex-col">
      <Navbar />

      {/* Authenticated sidebar overlay on public pages */}
      {isAuthenticated && (
        <>
          <Sidebar isOpen={sidebarOpen} />
          {sidebarOpen && (
            <div
              className="fixed inset-0 z-30 bg-black/30"
              onClick={closeSidebar}
            />
          )}
        </>
      )}

      {/* Push content below the fixed navbar */}
      <main className="flex-1 pt-16">
        <Outlet />
      </main>
      <Footer />
      {/* Floating chat guidance widget */}
      <QueryBox />
    </div>
  )
}

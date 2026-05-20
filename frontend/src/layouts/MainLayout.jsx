import { useState } from 'react'
import { Outlet } from 'react-router-dom'
import Navbar from '../components/Navbar'
import Footer from '../components/Footer'
import QueryBox from '../components/QueryBox'

/**
 * MainLayout – wraps all public-facing pages (Home, About, Services, etc.)
 */
export default function MainLayout() {
  return (
    <div className="min-h-screen flex flex-col">
      <Navbar />
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

import { Routes, Route } from 'react-router-dom'
import { lazy, Suspense } from 'react'
import Loader from '../components/Loader'
import MainLayout from '../layouts/MainLayout'
import DashboardLayout from '../layouts/DashboardLayout'
import { ProtectedRoute, AdminRoute, GuestRoute } from './ProtectedRoute'

// ── Lazy-load pages for code splitting ────────────────────────────────────────
const Home             = lazy(() => import('../pages/Home'))
const About            = lazy(() => import('../pages/About'))
const Services         = lazy(() => import('../pages/Services'))
const Contact          = lazy(() => import('../pages/Contact'))
const Login            = lazy(() => import('../pages/Login'))
const Register         = lazy(() => import('../pages/Register'))
const Dashboard        = lazy(() => import('../pages/Dashboard'))
const Jobs             = lazy(() => import('../pages/Jobs'))
const Training         = lazy(() => import('../pages/Training'))
const Resume           = lazy(() => import('../pages/Resume'))
const Counselling      = lazy(() => import('../pages/Counselling'))
const MyApplications   = lazy(() => import('../pages/MyApplications'))
const SavedJobs        = lazy(() => import('../pages/SavedJobs'))
const Notifications    = lazy(() => import('../pages/Notifications'))
const ProfileSettings  = lazy(() => import('../pages/ProfileSettings'))
const Schemes          = lazy(() => import('../pages/Schemes'))
const MyEnrollments    = lazy(() => import('../pages/MyEnrollments'))
const JobAlerts        = lazy(() => import('../pages/JobAlerts'))
const AdminDashboard   = lazy(() => import('../pages/AdminDashboard'))
const Reports          = lazy(() => import('../pages/Reports'))
const NotFound         = lazy(() => import('../pages/NotFound'))

const fallback = <Loader fullPage text="Loading page…" />

export default function AppRoutes() {
  return (
    <Suspense fallback={fallback}>
      <Routes>

        {/* ── Public routes (with Navbar + Footer) ─────────────────────────── */}
        <Route element={<MainLayout />}>
          <Route index         element={<Home />}     />
          <Route path="about"  element={<About />}    />
          <Route path="services" element={<Services />} />
          <Route path="contact"  element={<Contact />}  />
          <Route path="jobs"     element={<Jobs />}     />
          <Route path="training" element={<Training />} />

          {/* Guest-only routes (redirect authenticated users away) */}
          <Route element={<GuestRoute />}>
            <Route path="login"    element={<Login />}    />
            <Route path="register" element={<Register />} />
          </Route>
        </Route>

        {/* ── Authenticated user routes (with Sidebar) ────────────────────── */}
        <Route element={<ProtectedRoute />}>
          <Route element={<DashboardLayout />}>
            <Route path="dashboard"       element={<Dashboard />}        />
            <Route path="resume"          element={<Resume />}           />
            <Route path="counselling"     element={<Counselling />}      />
            <Route path="my-applications" element={<MyApplications />}  />
            <Route path="saved-jobs"      element={<SavedJobs />}        />
            <Route path="notifications"   element={<Notifications />}   />
            <Route path="profile"         element={<ProfileSettings />}  />
            <Route path="schemes"         element={<Schemes />}          />
            <Route path="my-enrollments"  element={<MyEnrollments />}   />
            <Route path="job-alerts"      element={<JobAlerts />}        />
          </Route>
        </Route>

        {/* ── Admin routes ─────────────────────────────────────────────────── */}
        <Route element={<AdminRoute />}>
          <Route element={<DashboardLayout />}>
            <Route path="admin"   element={<AdminDashboard />} />
            <Route path="reports" element={<Reports />}        />
          </Route>
        </Route>

        {/* 404 */}
        <Route path="*" element={<NotFound />} />

      </Routes>
    </Suspense>
  )
}

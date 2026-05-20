import { Link } from 'react-router-dom'
import { FiHome, FiArrowLeft } from 'react-icons/fi'

export default function NotFound() {
  return (
    <div className="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary-50 to-blue-50 px-6">
      <div className="text-center max-w-md">
        <div className="text-8xl font-extrabold text-primary-200 select-none mb-4">404</div>
        <h1 className="text-2xl font-extrabold text-gray-900 mb-2">Page Not Found</h1>
        <p className="text-gray-500 mb-8">
          The page you're looking for doesn't exist or has been moved.
        </p>
        <div className="flex gap-3 justify-center">
          <Link to="/" className="btn-primary flex items-center gap-2">
            <FiHome size={15} /> Go Home
          </Link>
          <button onClick={() => window.history.back()} className="btn-secondary flex items-center gap-2">
            <FiArrowLeft size={15} /> Go Back
          </button>
        </div>
      </div>
    </div>
  )
}

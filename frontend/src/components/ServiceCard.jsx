import { useNavigate } from 'react-router-dom'
import { colorClasses } from '../utils/helpers'
import { FiArrowRight } from 'react-icons/fi'

/**
 * ServiceCard – displays a single employment service/module.
 * Props:
 *   title       {string}
 *   description {string}
 *   icon        {string}  – emoji icon
 *   color       {string}  – tailwind color key
 *   path        {string}  – route to navigate on click
 *   count       {number}  – optional stat count
 */
export default function ServiceCard({ title, description, icon, color = 'blue', path, count }) {
  const navigate = useNavigate()
  const cls = colorClasses(color)

  return (
    <div
      onClick={() => navigate(path)}
      className="service-card group cursor-pointer animate-slide-up"
    >
      {/* Icon */}
      <div className={`w-14 h-14 rounded-2xl ${cls.bg} flex items-center justify-center text-2xl mb-4
                       group-hover:scale-110 transition-transform duration-300`}>
        {icon}
      </div>

      {/* Content */}
      <h3 className={`text-lg font-bold ${cls.text} mb-2`}>{title}</h3>
      <p className="text-sm text-gray-500 leading-relaxed mb-4">{description}</p>

      {/* Footer */}
      <div className="flex items-center justify-between">
        {count !== undefined && (
          <span className={`badge ${cls.bg} ${cls.text}`}>
            {count.toLocaleString()} available
          </span>
        )}
        <button className={`flex items-center gap-1 text-sm font-medium ${cls.text} ml-auto
                            group-hover:gap-2 transition-all duration-200`}>
          Explore <FiArrowRight size={14} />
        </button>
      </div>
    </div>
  )
}

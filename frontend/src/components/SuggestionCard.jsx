import { useNavigate } from 'react-router-dom'
import { colorClasses } from '../utils/helpers'
import { FiArrowRight } from 'react-icons/fi'

/**
 * SuggestionCard – shown inside the chat guidance interface.
 * Props:
 *   module      {string}
 *   description {string}
 *   icon        {string}
 *   color       {string}
 *   path        {string}
 *   compact     {boolean} – smaller variant for inside the chatbox
 */
export default function SuggestionCard({ module, description, icon, color = 'blue', path, compact = false }) {
  const navigate = useNavigate()
  const cls = colorClasses(color)

  if (compact) {
    return (
      <button
        onClick={() => navigate(path)}
        className={`w-full flex items-center gap-3 px-3 py-2 rounded-xl border ${cls.border}
                    ${cls.bg} hover:shadow-sm transition-all duration-200 text-left`}
      >
        <span className="text-lg">{icon}</span>
        <div className="flex-1 min-w-0">
          <p className={`text-sm font-semibold ${cls.text}`}>{module}</p>
          <p className="text-xs text-gray-500 truncate">{description}</p>
        </div>
        <FiArrowRight size={14} className={cls.text} />
      </button>
    )
  }

  return (
    <div
      onClick={() => navigate(path)}
      className={`flex items-center gap-4 p-4 rounded-2xl border ${cls.border} ${cls.bg}
                  hover:shadow-md transition-all duration-300 hover:-translate-y-1 cursor-pointer`}
    >
      <div className={`w-12 h-12 rounded-xl bg-white/60 flex items-center justify-center text-2xl flex-shrink-0`}>
        {icon}
      </div>
      <div className="flex-1">
        <h4 className={`font-bold ${cls.text}`}>{module}</h4>
        <p className="text-sm text-gray-600 mt-0.5">{description}</p>
      </div>
      <button className={`btn-primary text-sm py-1.5 px-3 ${cls.bg}`}>
        Go <FiArrowRight size={12} />
      </button>
    </div>
  )
}

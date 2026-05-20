import { useState, useRef, useEffect } from 'react'
import { analyseQuery } from '../utils/helpers'
import { FiSend, FiMessageCircle, FiX } from 'react-icons/fi'
import SuggestionCard from './SuggestionCard'
import { chatAPI } from '../api/axios'

// Initial bot greeting message
const WELCOME_MSG = {
  id:   0,
  from: 'bot',
  text: 'Hello! I\'m your Employment Guidance Assistant. Tell me what you\'re looking for — e.g., "I need a government job", "I want skill training", "Help with resume".',
  suggestions: [],
}

export default function QueryBox() {
  const [messages, setMessages] = useState([WELCOME_MSG])
  const [input,    setInput]    = useState('')
  const [loading,  setLoading]  = useState(false)
  const [open,     setOpen]     = useState(false)
  const bottomRef  = useRef(null)
  const inputRef   = useRef(null)

  // Auto-scroll to latest message
  useEffect(() => {
    bottomRef.current?.scrollIntoView({ behavior: 'smooth' })
  }, [messages])

  // Focus input when chat opens
  useEffect(() => {
    if (open) setTimeout(() => inputRef.current?.focus(), 100)
  }, [open])

  const sendMessage = async () => {
    const text = input.trim()
    if (!text) return

    const userMsg = { id: Date.now(), from: 'user', text }
    setMessages((prev) => [...prev, userMsg])
    setInput('')
    setLoading(true)

    try {
      // Try the backend guidance API first
      const { data } = await chatAPI.sendMessage(text)
      setMessages((prev) => [
        ...prev,
        { id: Date.now() + 1, from: 'bot', text: data.reply || 'Here are some suggestions:', suggestions: data.suggestions || [] },
      ])
    } catch {
      // Fallback: local keyword analysis
      const suggestions = analyseQuery(text)
      const reply = suggestions.length
        ? 'Based on your query, here are the relevant services:'
        : "I couldn't find an exact match. Please try keywords like \"job\", \"training\", \"resume\", or \"career counselling\"."

      setMessages((prev) => [
        ...prev,
        { id: Date.now() + 1, from: 'bot', text: reply, suggestions },
      ])
    } finally {
      setLoading(false)
    }
  }

  const handleKey = (e) => {
    if (e.key === 'Enter' && !e.shiftKey) {
      e.preventDefault()
      sendMessage()
    }
  }

  // ── Floating chat button (when collapsed) ──────────────────────────────────
  if (!open) {
    return (
      <button
        onClick={() => setOpen(true)}
        className="fixed bottom-6 right-6 z-50 w-14 h-14 bg-primary-600 hover:bg-primary-700
                   text-white rounded-full shadow-lg flex items-center justify-center
                   transition-all duration-300 hover:scale-110 animate-bounce-slow"
        aria-label="Open guidance chat"
      >
        <FiMessageCircle size={24} />
        <span className="absolute top-0 right-0 w-3 h-3 bg-green-400 rounded-full border-2 border-white" />
      </button>
    )
  }

  // ── Chat window ────────────────────────────────────────────────────────────
  return (
    <div className="fixed bottom-6 right-6 z-50 w-80 sm:w-96 flex flex-col bg-white
                    rounded-2xl shadow-2xl border border-gray-200 animate-slide-up overflow-hidden"
         style={{ height: '520px' }}>

      {/* Header */}
      <div className="bg-gradient-primary px-4 py-3 flex items-center justify-between">
        <div className="flex items-center gap-3">
          <div className="w-9 h-9 rounded-full bg-white/20 flex items-center justify-center text-lg">
            🤖
          </div>
          <div>
            <p className="text-white font-semibold text-sm">Guidance Assistant</p>
            <div className="flex items-center gap-1">
              <span className="w-2 h-2 bg-green-400 rounded-full" />
              <span className="text-white/70 text-xs">Online</span>
            </div>
          </div>
        </div>
        <button
          onClick={() => setOpen(false)}
          className="p-1.5 rounded-lg text-white/70 hover:text-white hover:bg-white/10 transition"
        >
          <FiX size={18} />
        </button>
      </div>

      {/* Messages */}
      <div className="flex-1 overflow-y-auto p-4 space-y-4 scrollbar-thin bg-gray-50">
        {messages.map((msg) => (
          <div key={msg.id} className={`flex ${msg.from === 'user' ? 'justify-end' : 'justify-start'}`}>
            <div className="max-w-[85%] space-y-2">
              {msg.from === 'bot' && (
                <div className="w-7 h-7 rounded-full bg-primary-100 flex items-center justify-center text-sm mb-1">
                  🤖
                </div>
              )}
              <div className={msg.from === 'user' ? 'chat-bubble-user' : 'chat-bubble-bot'}>
                <p className="text-sm">{msg.text}</p>
              </div>
              {/* Suggestions */}
              {msg.suggestions?.length > 0 && (
                <div className="space-y-2 mt-2">
                  {msg.suggestions.map((s, i) => (
                    <SuggestionCard key={i} {...s} compact />
                  ))}
                </div>
              )}
            </div>
          </div>
        ))}

        {loading && (
          <div className="flex justify-start">
            <div className="chat-bubble-bot">
              <div className="flex gap-1 items-center py-1">
                {[0, 1, 2].map((i) => (
                  <span
                    key={i}
                    className="w-2 h-2 bg-gray-400 rounded-full animate-bounce"
                    style={{ animationDelay: `${i * 150}ms` }}
                  />
                ))}
              </div>
            </div>
          </div>
        )}

        <div ref={bottomRef} />
      </div>

      {/* Input */}
      <div className="p-3 border-t border-gray-100 bg-white">
        <div className="flex gap-2">
          <input
            ref={inputRef}
            type="text"
            value={input}
            onChange={(e) => setInput(e.target.value)}
            onKeyDown={handleKey}
            placeholder="Type your query…"
            className="flex-1 px-3 py-2 text-sm border border-gray-200 rounded-xl focus:outline-none
                       focus:ring-2 focus:ring-primary-500 bg-gray-50"
          />
          <button
            onClick={sendMessage}
            disabled={!input.trim() || loading}
            className="w-9 h-9 bg-primary-600 hover:bg-primary-700 text-white rounded-xl flex items-center
                       justify-center transition disabled:opacity-50 disabled:cursor-not-allowed flex-shrink-0"
          >
            <FiSend size={15} />
          </button>
        </div>
        {/* Quick prompts */}
        <div className="flex flex-wrap gap-1 mt-2">
          {['I need jobs', 'Skill training', 'Resume help', 'Career advice'].map((q) => (
            <button
              key={q}
              onClick={() => { setInput(q); inputRef.current?.focus() }}
              className="text-xs px-2 py-1 rounded-full bg-primary-50 text-primary-600
                         hover:bg-primary-100 transition border border-primary-100"
            >
              {q}
            </button>
          ))}
        </div>
      </div>
    </div>
  )
}
